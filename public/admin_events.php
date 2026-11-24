<?php
require_once dirname(__DIR__) . '/app/config.php';
require_admin();
// Release the PHP session lock so normal admin page requests are not blocked by EventSource.
session_write_close();
header('Content-Type: text/event-stream; charset=utf-8');
header('Cache-Control: no-cache, no-transform');
header('X-Accel-Buffering: no');
@ini_set('zlib.output_compression', '0');
@ini_set('output_buffering', 'off');
if (ob_get_level()) { @ob_end_flush(); }
$started = time();
$previous = null;
while (!connection_aborted() && (time() - $started) < 20) {
    try {
        $count = (int)$pdo->query("SELECT COUNT(*) FROM orders WHERE status='pending'")->fetchColumn();
        if ($count !== $previous) {
            echo 'event: pending-orders' . "\n";
            echo 'data: ' . json_encode(['count' => $count], JSON_UNESCAPED_UNICODE) . "\n\n";
            $previous = $count;
        } else {
            echo ": keep-alive\n\n";
        }
    } catch (Throwable $e) { error_log('[IT-Books SSE] ' . $e->getMessage()); break; }
    @ob_flush(); @flush();
    sleep(4);
}
