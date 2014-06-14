<?php
/**
 * ArrayLogger class  - ArrayLogger.php file
 *
 * @author     Dmitriy Tyurin <fobia3d@gmail.com>
 * @copyright  Copyright (c) 2014 Dmitriy Tyurin
 */

namespace Fobia\Debug;

use \Psr\Log\AbstractLogger;
use \Psr\Log\LogLevel;

/**
 * ArrayLogger class
 *
 * @package   Fobia.Debug
 */
class ArrayLogger extends AbstractLogger
{
    protected $list = array();
    public $level = 0;

    public function log($level, $message, array $context = array())
    {
        switch ($level) {
            case LogLevel::EMERGENCY:
                $l = 600;
                break;
            case LogLevel::ALERT:
                $l = 550;
                break;
            case LogLevel::CRITICAL:
                $l = 500;
                break;
            case LogLevel::ERROR:
                $l = 400;
                break;
            case LogLevel::WARNING:
                $l = 300;
                break;
            case LogLevel::NOTICE:
                $l = 250;
                break;
            case LogLevel::INFO:
                $l = 200;
                break;
            case LogLevel::DEBUG:
                $l = 100;
                break;
            default:
                $l = 50;
        }
        if ($l > $this->level) {
            return;
        }

        $this->list[] = array(
            'time'    => sprintf("%6s", substr(microtime(true) - TIME_START, 0, 6)),
            'memory'  => sprintf("%6s", round(memory_get_usage() / 1024 / 1024, 2) . 'MB'),
            'level'   => $level,
            'message' => $message,
            'context' => $context
        );

        error_log($message, 3, LOGS_DIR . '/error.log');
    }

    public function getRows()
    {
        return $list;
    }


    public function render()
    {
        $htime = sprintf("%-8s", 'time');
        $hlevel = sprintf("%-8s", 'level');

        $html = <<<HTML
<div id="ac-logger-switch">DBG</div>
<div id="ac-logger" class="hidden">
    <div class="content">
        <table style="width: 100%;">
            <thead>
                <tr >
                    <th class="number"   style="width: 30px;">№</th>
                    <th class="time"     style="width: 70px;">{$htime}</th>
                    <th class="level"    style="width: 85px;">{$hlevel}</th>
                    <th class="message">message</th>
                </tr>
            </thead>
            <tbody>
HTML;

        foreach ($this->list as $row) {
            $html .= '<tr>'
                . '<td class="number">' . sprintf("%'02d", ++$i) . '</td>'
                . '<td class="time">' .  sprintf("%-9s", $row['time']) . '</td>'
                . '<td class="level">' .  htmlspecialchars(sprintf("%-9s", '[' . $row['level'] . ']')) . '</td>'
                . '<td class="message">' .  $row['message'] . '</td>'
                . '</tr>';
        }

        $html .= '</tbody> </table> </div> </div>';
        $html .= '';

        return $html;
    }

}