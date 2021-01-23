<?php

namespace Biblionet;

class Logger
{

    const SUCCESS = 'success';
    const ERROR = 'error';
    const INFO = 'info';
    const WARNING = 'warning';

    private $show = [];
    private $colors = [
        self::SUCCESS => ["CLI" => "32m", "WEB" => "#00FF00"],
        self::ERROR => ["CLI" => "31m", "WEB" => "#FF0000"],
        self::INFO => ["CLI" => "34m", "WEB" => "#0000FF"],
        self::WARNING => ["CLI" => "33m", "WEB" => "#FFFF00"]
    ];

    public function __construct($show = [self::SUCCESS, self::ERROR, self::INFO, self::WARNING])
    {
        $this->show = $show;
    }

    public function enable()
    {
        $this->debug = true;
    }

    public function disable()
    {
        $this->debug = false;
    }

    public function log($type, $entity, $title, $text = "", $percentage = NULL)
    {

        if (in_array($type, $this->show)) {
            if (ob_get_level() == 0) ob_start();
            $Timestamp = new \Datetime;
            if (Helper::isCli()) {
                $output = $Timestamp->format('Y-m-d H:i') . ": ";
                $output .= "[\033[" . $this->colors[$type]["CLI"] . " " . $type . " \033[0m]";
                $output .= "[ " . $entity . " ]";
                if ($percentage) $output .= "[\033[1m " . $percentage . "%\033[0m ] ";
                $output .= "[ " . $title . " ]";
                $output .= "[ " . $text . " ]";
                $output .= PHP_EOL;
            } else {
                $output = '<span style="font-family:\'courier new\';font-size:11px;">';
                $output .= $Timestamp->format('Y-m-d H:i') . ': ';
                $output .= '[ <span style="color:' . $this->colors[$type]["WEB"] . '">' . $type . '</span> ]';
                $output .= '[ ' . $entity . ' ] ';
                if ($percentage) $output .= '[ <span style="font-weight:bold">' . $percentage . '%</span> ] ';
                $output .= '[ ' . $title . ' ] ';
                $output .= '[ ' . $text . ' ]';
                $output .= '</span><br/>';
            }

            echo $output;

            ob_flush();
            flush();
            //TODO: add logging to database
        }
    }
}
