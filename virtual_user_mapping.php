<?php

/*
 * Virtual User mapping multiple user logins for one account
 *
 * @version 1.0
 * @license GNU GPLv3+
 * @author Pierre Arlt
 */
class virtual_user_mapping extends rcube_plugin
{
    const LOGIN_DATA_USER = 'user';
    const LOGIN_DATA_PASSWORD = 'password';
    const LOGIN_DATA_PASS = 'pass';

    /** @var  rcmail */
    private $app;

    /** @var  array */
    private $virtualUserMapping;

    /** @var string  */
    private $logName = 'virtual_user_log';


    function init()
    {
        $this->app = rcmail::get_instance();
        $this->add_hook('authenticate', array($this, 'login'));
    }


    /**
     * @param $loginData
     * @return mixed
     */
    public function login($loginData)
    {
        if (strpos($loginData[self::LOGIN_DATA_USER], '#') !== false) {
            $this->virtualUserMapping = $this->app->config->get('virtualUserMapping');
            if (!$this->virtualUserMapping) {
                $this->writeLog('virtualUserMapping no active');
                return $loginData;
            }

            $dataNameArr = explode('#', $loginData[self::LOGIN_DATA_USER]);
            if (!isset($dataNameArr[0]) || !isset($dataNameArr[1])) {
                $this->writeLog('1 | no split ' . $loginData[self::LOGIN_DATA_USER]);
                return $loginData;
            }

            $dataAccountArr = explode('@', $dataNameArr[1]);
            $dataVirtualName = $dataNameArr[0];
            $dataDomain = $dataAccountArr [1];

            if (!isset($dataAccountArr[0]) || !isset($dataVirtualName) || !isset($dataDomain)) {
                $this->writeLog('2 | dataAccountArr  not set: ' . $loginData[self::LOGIN_DATA_USER]);
                $this->writeLog('2.1 | dataVirtualName  not set: ' . $loginData[self::LOGIN_DATA_USER]);
                $this->writeLog('2.2 | dataDomain  not set: ' . $loginData[self::LOGIN_DATA_USER]);
                return $loginData;
            }

            $dataRealAccount = $dataAccountArr[0];
            if (!isset($this->virtualUserMapping[$dataDomain][$dataRealAccount][self::LOGIN_DATA_PASS])) {
                $this->writeLog('3 | config pass not set' . $loginData[self::LOGIN_DATA_USER]);
                return $loginData;
            }

            $realPass = $this->virtualUserMapping[$dataDomain][$dataRealAccount][self::LOGIN_DATA_PASS];
            if (!isset($this->virtualUserMapping[$dataDomain][$dataRealAccount]['users'][$dataVirtualName])) {
                $this->writeLog(
                    '4 | virtualuser exists not in config:'
                    . $dataVirtualName . ' '
                    . $loginData[self::LOGIN_DATA_USER]
                );
                return $loginData;
            }

            $loginPass = $this->virtualUserMapping[$dataDomain][$dataRealAccount]['users'][$dataVirtualName];
            if (!isset($loginPass) || trim($loginPass) == '') {
                $this->writeLog('5 | no pass in request: ' . $loginData[self::LOGIN_DATA_USER]);
                return $loginData;
            }

            if ($loginPass === $loginData[self::LOGIN_DATA_PASS]) {
                $this->writeLog('7 | pass is equal: ' . $loginData[self::LOGIN_DATA_USER]);
                $loginData[self::LOGIN_DATA_USER] = $dataRealAccount;
                $loginData[self::LOGIN_DATA_PASS] = $realPass;
            } else {
                $this->writeLog('6 | pass not equal virtualconfig/user input');
            }
        }

        return $loginData;
    }


    /**
     * @param string $data
     */
    function writeLog($data)
    {
        $this->app->write_log($this->logName, $data);
    }
}
