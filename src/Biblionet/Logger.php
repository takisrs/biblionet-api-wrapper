<?php

namespace takisrs\Biblionet;

/**
 * A helper class to output logs.
 * 
 * @todo Add extra output options: file, mail etc
 * @todo handle errors with exit codes
 * @author Panagiotis Pantazopoulos <takispadaz@gmail.com>
 */
class Logger
{

    /**
     * Success log type
     */
    const SUCCESS = 'success';

    /**
     * Error log type
     */
    const ERROR = 'error';

    /**
     * Info log type
     */
    const INFO = 'info';

    /**
     * Warning log type
     */
    const WARNING = 'warning';

    /**
     * The log types to handle
     *
     * @var array
     */
    private array $show = [];

    /**
     * The colors for each log type. For cli or web server output.
     *
     * @var array
     */
    private $colors = [
        self::SUCCESS => ["CLI" => "32m", "WEB" => "#00FF00"],
        self::ERROR => ["CLI" => "31m", "WEB" => "#FF0000"],
        self::INFO => ["CLI" => "34m", "WEB" => "#0000FF"],
        self::WARNING => ["CLI" => "33m", "WEB" => "#FFFF00"]
    ];

    /**
     * logs enabled or not
     */
    private bool $debug;

    /**
     * Constructor.
     * 
     * @param array $show An array with the error types to be handled by the class
     */
    public function __construct($show = [self::SUCCESS, self::ERROR, self::INFO, self::WARNING])
    {
        $this->enable(); // enable the logs output
        $this->show = $show;
    }

    /**
     * Enables the logging
     *
     * @return void
     */
    public function enable(): void
    {
        $this->debug = true;
    }

    /**
     * Disables the logging
     *
     * @return void
     */
    public function disable(): void
    {
        $this->debug = false;
    }

    /**
     * Logs an entry.
     *
     * @param string $type The type of the log entry
     * @param string $entity
     * @param string $title A title describing the log entry
     * @param string $text A description for the log entry
     * @param string $percentage A value indicating the percentage of completion
     * @return void
     */
    public function log(string $type, string $entity, string $title, string $text = "", float $percentage = NULL): void
    {

        if ($this->debug && in_array($type, $this->show)) {
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
        }
    }

}
