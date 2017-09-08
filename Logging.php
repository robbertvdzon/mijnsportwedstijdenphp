<?

/**
 * Logging class:
 * - contains lfile, lopen, lclose and lwrite methods
 * - lfile sets path and name of log file
 * - lwrite will write message to the log file
 * - lclose closes log file
 * - first call of the lwrite will open log file implicitly
 * - message is written with the following format: hh:mm:ss (script name) message
 */
class Logging {
    private $disabled = true;

    // define default log file
    private $log_file = 'c:\\temp\\phplog.txt';

    // define default newline character
    private $nl = "\n";
    // define file pointer
    private $fp = null;
    // set log file (path and name)
    // set log file (path and name)
    public function lfile($path) {
        $this->log_file = $path;
    }

    // write message to the log file
    public function lwrite($message) {
        if ($this->disabled) return;
        // if file pointer doesn't exist, then open log file
        if (!$this->fp) {
            $this->lopen();
        }
        // define script name
        $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        // define current time
        $time = date('H:i:s');
        // write current time, script name and message to the log file
        fwrite($this->fp, "$time ($script_name) $message". $this->nl);
    }
    // close log file (it's always a good idea to close a file when you're done with it)
    public function lclose() {
        if ($this->disabled) return;
        fclose($this->fp);
    }
    // open log file
    private function lopen() {
        if ($this->disabled) return;
        // define log file path and name
        $lfile = $this->log_file;
        // set newline character to "\r\n" if script is used on Windows
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->nl = "\r\n";
        }
        // open log file for writing only; place the file pointer at the end of the file
        // if the file does not exist, attempt to create it
        $this->fp = fopen($lfile, 'a') or exit("Can't open $lfile!");
    }
}

?>