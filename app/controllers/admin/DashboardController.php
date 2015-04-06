<?php

namespace app\controllers\admin;
use Auth, BaseController, Form, Input, Redirect, Sentry, View, Log, FeedReader, Asset;

class DashboardController extends BaseController
{
    public function dashboard()
    {
	    if ( PHP_OS == 'Linux') {
		    $fh = fopen('/proc/uptime', 'r');
		    $uptime = fgets($fh);
		    fclose($fh);
		    $u = explode('.', $uptime, 2);
		    $uptime = sec2human($u[0]);

		    $fh = fopen('/proc/meminfo', 'r');
		    $mem = 0;
		    while ($line = fgets($fh)) {
			    $pieces = array();

			    if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
				    $memtotal = $pieces[1];
			    }
			    if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $pieces)) {
				    $memfree = $pieces[1];
			    }
			    if (preg_match('/^Cached:\s+(\d+)\skB$/', $line, $pieces)) {
				    $memcache = $pieces[1];
			    }
			    if (preg_match('/^SwapTotal:\s+(\d+)\skB$/', $line, $pieces)) {
				    $swaptotal = $pieces[1];
			    }
			    if (preg_match('/^SwapFree:\s+(\d+)\skB$/', $line, $pieces)) {
				    $swapfree = $pieces[1];
				    break;
			    }
		    }
		    fclose($fh);

		    $mem_buffered = $memcache + $memfree;
		    $mem_used = $memtotal - $memfree;
		    $memory_pct = round( $mem_buffered / $memtotal * 100);
		    $swap_used = $swaptotal - $swapfree;

		    $hdd_total = disk_total_space("/");
		    $hdd_free = disk_free_space("/");
		    $hdd_math = $hdd_free / $hdd_total * 100;
		    $hdd_pct = round($hdd_math);

		    $hdd_total = round($hdd_total / 1024 / 1024);
		    $hdd_free = round($hdd_free / 1024 / 1024);

		    // Create MB's instead of kB's
		    $mem_used = round(($mem_used / 1024));
		    $mem_buffered = round(($mem_buffered / 1024));
		    if (!empty($swap_used)){
			    $swap_used = round(($swap_used / 1024));
		    }
		    $memtotal = round(($memtotal / 1024));
		    $memfree = round(($memfree / 1024));
		    $mb=' MB';
		    $pct='%';
		    $gb=' GB';
	    } else {
		    $uptime="N/A";
		    $hdd="N/A";
		    $mem_used="N/A";
		    $mem_total="N/A";
		    $mem_buffered="N/A";
		    $swap_used="N/A";
		    $memfree="N/A";
		    $memtotal="N/A";
		    $hdd_total="N/A";
		    $hdd_free="N/A";
		    $hdd_pct="N/A";
		    $mb='';
		    $gb='';
		    $pct='';
	    }

	    $rss = FeedReader::read('http://www.reportula.org/reportula/?feed=rss2');
	    return View::make('admin.dashboard', array(
				    'rss'             => $rss,
				    'system'	      => PHP_OS,
				    'host'	      => php_uname('n'),
				    'kernel'	      => php_uname('r'),
				    'phpversion'      => phpversion(),
				    'used_mem'        => $mem_used . $mb,
				    'total_mem'       => $memtotal . $mb,
				    'buffered_mem'    => $mem_buffered . $mb,
				    'used_swap'	      => $swap_used . $mb,
				    'free_mem'        => $memfree . $mb,
				    'hdd_total'       => $hdd_total . $gb,
				    'hdd_free'        => $hdd_free . $gb,
				    'hdd_pct'         => $hdd_pct . $pct,
				    'uptime'          => $uptime
				    ));
    }

}

function sec2human($time) {
	$seconds = $time%60;
	$mins = floor($time/60)%60;
	$hours = floor($time/60/60)%24;
	$days = floor($time/60/60/24);
	return $days > 0 ? $days . ' day'.($days > 1 ? 's' : '') : $hours.':'.$mins.':'.$seconds;
}
