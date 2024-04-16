<?php
namespace ScriptsSC;

require_once __DIR__ . '/../scripts_local/CfgPw.php';

class Cfg {
    // Akord
    const AKORD_DB_SERVER = '10.80.1.20';
    const AKORD_DB_NAME = 'Akord';
    const AKORD_DB_NAME_CVICNA = 'Akord_cvicna';
    
    // AMOS
    const AMOS_DB_SERVER = '10.80.0.23';
    const AMOS_DB_NAME = 'AMOS';
    const AMOS_DB_NAME_CVICNA = 'AMOS_CVICNA';
    
    // CarShare
    const CARSHARE_DB_SERVER = '10.40.20.49';
    const CARSHARE_DB_PORT = '5432';
    const CARSHARE_DB_NAME = 'carshare';
    const CARSHARE_DB_USER = 'postgres';
    
    // DWH Fons
    const DWH_FONS_DB_SERVER = '10.80.1.20';
    const DWH_FONS_DB_NAME = 'DWH_FONS';
    const DWH_FONS_DB_USER = 'mkarta_dwh_fons';
    
    // EVIDO
    const EVIDO_DB_SERVER = '10.80.0.23';
    const EVIDO_DB_NAME = 'EVIDO';
    const EVIDO_DB_USER = 'evido';
    const EVIDO_DB_USER_EVIDO_PERMONIK = 'evido';
    
    // Statistika eReceptu
    const HLIDANI_ERECEPTY_DB_SERVER = '10.80.1.20';
    const HLIDANI_ERECEPTY_DB_NAME = 'Akord';
    const HLIDANI_ERECEPTY_DB_NAME_CVICNA = 'Akord_cvicna';
    const HLIDANI_ERECEPTY_DB_USER = 'akeso_erecepty';
    
    // Kamery
    const KAMERY_DB_SERVER = '10.40.31.5';
    const KAMERY_DB_NAME = 'Surveillance';
    const KAMERY_DB_USER = 'mkarta';
    
    // Katetr
    const KATETR_DB_SERVER = '10.80.1.21';
    const KATETR_DB_PORT = '5432';
    const KATETR_DB_NAME = 'katetr';
    const KATETR_DB_USER = 'katetr';
    
    // Mevris ReX
    const MEVRIS_DB_SERVER = '10.40.20.4';
    const MEVRIS_DB_NAME = 'med_jbsoft';
    const MEVRIS_DB_USER = 'rex';
    
    // mKarta
    const MKARTA_DB_SERVER = '10.80.1.21';
    const MKARTA_DB_PORT = '5432';
    const MKARTA_DB_NAME_NH = 'mcalls';
    const MKARTA_DB_USER_NH = 'mcalls';
    const MKARTA_DB_NAME_RNB = 'mcallsnb';
    const MKARTA_DB_USER_RNB = 'mcallsnb';
    const MKARTA_DB_NAME_PAR = 'mcallspar';
    const MKARTA_DB_USER_PAR = 'mcallspar';
    const MKARTA_DB_USER_PRACURAZ = 'mkarta_pracuraz';
    const MKARTA_DB_NAME_CENTRAL = 'mcalls_central';
    const MKARTA_DB_USER_CENTRAL = 'mcalls_central';
    const MKARTA_DB_USER_CENTRAL_RO = 'mcalls_central_ro'; // read-only
    
    const MKARTA_DB_USER_PERMONIK_LOADER = 'permonik_loader';
    
    // Permoník
    const PERMONIK_DB_SERVER = '10.40.20.101';
    const PERMONIK_DB_PORT = '5432';
    const PERMONIK_DB_USER_LOADER = 'permonik_loader';
    const PERMONIK_DB_USER_CLIENT = 'permonik_client';
    const PERMONIK_DB_USER_CLIENT_PLUS_CARDS = 'permonik_client_plus_cards';
    const PERMONIK_DB_USER_CLIENT_ALL_USERS_DATA = 'permonik_client_all_users_data';
    const PERMONIK_DB_NAME_NH = 'permonik_nh';
    const PERMONIK_DB_NAME_RNB = 'permonik_rnb';
    const PERMONIK_DB_NAME_PAR = 'permonik_par';
    
    // Pořadník pacientů
    const PORADNIK_PACIENTU_DB_USER = 'poradnik_pacientu';
    
    // Recepty
    const RECEPTY_DB_SERVER = '10.80.1.21';
    const RECEPTY_DB_PORT = '5432';
    const RECEPTY_DB_NAME = 'ber_lekarna_rec';
    const RECEPTY_DB_USER = 'ber_lekarna_rec';
    
    // Zavory
    const ZAVORY_DB_SERVER = '10.40.37.10';
    const ZAVORY_DB_PORT = '3050';
    const ZAVORY_DB_NAME = 'TURNIKET2017';
    const ZAVORY_DB_USER = 'SYSDBA';
    
    // PHPMailer
    const PHPMAILER_HOST = '10.40.20.5';
    const PHPMAILER_SMTP_AUTH = false;
    const PHPMAILER_USERNAME = '';
    const PHPMAILER_SMTP_SECURE = 'tls';
    const PHPMAILER_PORT = 25;
    const PHPMAILER_CHARSET = 'UTF-8';
    const PHPMAILER_DEFAULT_FROM_EMAIL = 'mkarta@nember.cz';
    const PHPMAILER_DEFAULT_FROM_NAME = 'mKarta';
    const PHPMAILER_INFO_RECIPIENTS = 'voparil@nember.cz';
    const PHPMAILER_EXCEPTION_RECIPIENTS = 'voparil@nember.cz';
    const PHPMAILER_SMTP_OPTIONS = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ],
        ];
}
?>