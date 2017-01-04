<?php

class TestShell extends Shell {

    public function main() {
        $this->test1();
    }

    public function test1() {
        $myfile = fopen("/var/www/html/app/tmp/logs/logsshell.txt", "w") or die("Unable to open file!");
        $txt = "This is log in time: " . date("Y-m-d H:i:s") . "\n";
        fwrite($myfile, "\n" . $txt);
        fclose($myfile);
    }

}
