<?php

namespace api\components;


use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;

class YQErrorLogger extends YQLogger
{
    /**
     * Writes log messages to a file.
     * @throws InvalidConfigException if unable to open the log file for writing
     */
    public function export()
    {
        $now = strval(DateTimeHelper::now('Y-m-d'));
        $this->logFile = Yii::$app->params['logBasePath'].'error_log-' . $now . '.log';

        $text = implode("\n", array_map([$this, 'formatMessage'], $this->messages)) . "\n";
        if (($fp = @fopen($this->logFile, 'a')) === false) {
            throw new InvalidConfigException("Unable to append to log file: {$this->logFile}");
        }
        @flock($fp, LOCK_EX);
        // clear stat cache to ensure getting the real current file size and not a cached one
        // this may result in rotating twice when cached file size is used on subsequent calls
        clearstatcache();
        if (@filesize($this->logFile) > $this->maxFileSize * 1024) {
            $this->rotateFiles();
            @flock($fp, LOCK_UN);
            @fclose($fp);
            @file_put_contents($this->logFile, $text, FILE_APPEND | LOCK_EX);
        } else {
            @fwrite($fp, $text);
            @flock($fp, LOCK_UN);
            @fclose($fp);
        }
        if ($this->fileMode !== null) {
            @chmod($this->logFile, $this->fileMode);
        }
    }
} 