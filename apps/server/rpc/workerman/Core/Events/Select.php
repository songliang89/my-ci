<?php 
namespace Man\Core\Events;
/**
 * 
 * select 轮询封装
 * 如果没有其它可用库worker进程也会自动使用该库
 * 
* @author walkor <walkor@workerman.net>
 */

class Select implements BaseEvent
{
    /**
     * 记录所有事件处理函数及参数
     * @var array
     */
    public $allEvents = array();
    
    /**
     * 记录所有信号处理函数及参数
     * @var array
     */
    public $signalEvents = array();
    
    /**
     * 监听的读描述符
     * @var array
     */
    public $readFds = array();
    
    /**
     * 监听的写描述符
     * @var array
     */
    public $writeFds = array();
    
    /**
     * 添加事件
     * @see \Man\Core\Events\BaseEvent::add()
     */
    public function add($fd, $flag, $func, $args = null)
    {
        // key
        $fd_key = (int)$fd;
        switch ($flag)
        {
            // 可读事件
            case self::EV_READ:
                $this->allEvents[$fd_key][$flag] = array('args'=>$args, 'func'=>$func, 'fd'=>$fd);
                $this->readFds[$fd_key] = $fd;
                break;
            // 写事件 目前没用到，未实现
            case self::EV_WRITE:
                $this->allEvents[$fd_key][$flag] = array('args'=>$args, 'func'=>$func, 'fd'=>$fd);
                $this->writeFds[$fd_key] = $fd;
                break;
            // 信号处理事件
            case self::EV_SIGNAL:
                $this->signalEvents[$fd_key][$flag] = array('args'=>$args, 'func'=>$func, 'fd'=>$fd);
                pcntl_signal($fd, array($this, 'signalHandler'));
                break;
        }
        
        return true;
    }
    
    /**
     * 回调信号处理函数
     * @param int $signal
     */
    public function signalHandler($signal)
    {
        call_user_func_array($this->signalEvents[$signal][self::EV_SIGNAL]['func'], array($signal, self::EV_SIGNAL, $signal));
    }
    
    /**
     * 删除某个fd的某个事件
     * @see \Man\Core\Events\BaseEvent::del()
     */
    public function del($fd ,$flag)
    {
        $fd_key = (int)$fd;
        switch ($flag)
        {
            // 可读事件
            case self::EV_READ:
                unset($this->allEvents[$fd_key][$flag], $this->readFds[$fd_key]);
                if(empty($this->allEvents[$fd_key]))
                {
                    unset($this->allEvents[$fd_key]);
                }
                break;
            // 可写事件
            case self::EV_WRITE:
                unset($this->allEvents[$fd_key][$flag], $this->writeFds[$fd_key]);
                if(empty($this->allEvents[$fd_key]))
                {
                    unset($this->allEvents[$fd_key]);
                }
                break;
            // 信号
            case self::EV_SIGNAL:
                unset($this->signalEvents[$fd_key]);
                pcntl_signal($fd, SIG_IGN);
                break;
        }
        return true;
    }

    /**
     * 事件轮训库主循环
     * @see \Man\Core\Events\BaseEvent::loop()
     */
    public function loop()
    {
        $e = null;
        while (1)
        {
            $read = $this->readFds;
            $write = $this->writeFds;
            // 触发信号处理函数
            pcntl_signal_dispatch();
            // stream_select false：出错 ; 0：超时
            if(!($ret = @stream_select($read, $write, $e, PHP_INT_MAX)))
            {
                // 超时
                if($ret === 0)
                {
                }
                // 被信号打断
                elseif($ret === false)
                {
                }
                // 触发信号处理函数
                pcntl_signal_dispatch();
                continue;
            }
            
            // 检查所有可读描述符
            foreach($read as $fd)
            {
                $fd_key = (int) $fd;
                if(isset($this->allEvents[$fd_key][self::EV_READ]))
                {
                    call_user_func_array($this->allEvents[$fd_key][self::EV_READ]['func'], array($this->allEvents[$fd_key][self::EV_READ]['fd'], self::EV_READ,  $this->allEvents[$fd_key][self::EV_READ]['args']));
                }
            }
            
            // 检查可写描述符
            foreach($write as $fd)
            {
                $fd_key = (int) $fd;
                if(isset($this->allEvents[$fd_key][self::EV_WRITE]))
                {
                    call_user_func_array($this->allEvents[$fd_key][self::EV_WRITE]['func'], array($this->allEvents[$fd_key][self::EV_WRITE]['fd'], self::EV_WRITE,  $this->allEvents[$fd_key][self::EV_WRITE]['args']));
                }
            }
        }
    }
    
}

