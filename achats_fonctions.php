<?php

function date_future($date, $lapse) {
	return date('Y-m-d H:i:s', strtotime($lapse, strtotime($date)) );
}