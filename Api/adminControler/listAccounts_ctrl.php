<?php
$accountRepo = new AccountRepository();
$accounts = $accountRepo->listAccounts();

sendJsonResponse($accounts);
