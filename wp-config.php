<?php
/**
 * WordPress için taban ayar dosyası.
 *
 * Bu dosya şu ayarları içerir: MySQL ayarları, tablo öneki,
 * gizli anahtaralr ve ABSPATH. Daha fazla bilgi için
 * {@link https://codex.wordpress.org/Editing_wp-config.php wp-config.php düzenleme}
 * yardım sayfasına göz atabilirsiniz. MySQL ayarlarınızı servis sağlayıcınızdan edinebilirsiniz.
 *
 * Bu dosya kurulum sırasında wp-config.php dosyasının oluşturulabilmesi için
 * kullanılır. İsterseniz bu dosyayı kopyalayıp, ismini "wp-config.php" olarak değiştirip,
 * değerleri girerek de kullanabilirsiniz.
 *
 * @package WordPress
 */
define('FS_METHOD','direct');

// ** MySQL ayarları - Bu bilgileri sunucunuzdan alabilirsiniz ** //
/** WordPress için kullanılacak veritabanının adı */
define( 'DB_NAME', 'quuzydb' );

/** MySQL veritabanı kullanıcısı */
define( 'DB_USER', 'quuzydb' );

/** MySQL veritabanı parolası */
define( 'DB_PASSWORD', '48186hasokeyk' );

/** MySQL sunucusu */
define( 'DB_HOST', 'localhost' );

/** Yaratılacak tablolar için veritabanı karakter seti. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Veritabanı karşılaştırma tipi. Herhangi bir şüpheniz varsa bu değeri değiştirmeyin. */
define('DB_COLLATE', '');

/**#@+
 * Eşsiz doğrulama anahtarları.
 *
 * Her anahtar farklı bir karakter kümesi olmalı!
 * {@link http://api.wordpress.org/secret-key/1.1/salt WordPress.org secret-key service} servisini kullanarak yaratabilirsiniz.
 * Çerezleri geçersiz kılmak için istediğiniz zaman bu değerleri değiştirebilirsiniz. Bu tüm kullanıcıların tekrar giriş yapmasını gerektirecektir.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Kzbd0q(GTVAgAhp(Y?p`>OoO>QVO[ORZ~|BfZoB%bn8Hm;naJtP^<|m=GXrd^ Ao' );
define( 'SECURE_AUTH_KEY',  'tuZ6Ic;9z|RE0A~TdVPpHdG1!]T{M*qLhR`mZ3z,Wa_pZ6KL;kwOV8I`*yF4wTqa' );
define( 'LOGGED_IN_KEY',    'f4:t-9uNC2h[!+DqcT.J+r vs?s0{(#3u?3-qx(N! HhC70#^Z9Hg;-a#xd;-/=P' );
define( 'NONCE_KEY',        '%e,E`d&v8gaI=(+Q0LG=|{L|LQl<3}pR34^IkiB]L3<8W+;(4Jfp9MC5v{oPfw<>' );
define( 'AUTH_SALT',        '(y+c0L@^jz7?GdQ%et%5)GfKiOb`wDO:(sggVInj5}nOPXoXI5-|2_NT tN0;i/x' );
define( 'SECURE_AUTH_SALT', '-F##(5*^x2#n~sVV|2eJ3!9Q^`mb`4Sj2mC;L1^ SO>T5,X6=axS. <^#cmZ@i;N' );
define( 'LOGGED_IN_SALT',   '*EbhW~j`TCe?NdVcq#]3_SKBCigCxMjvLNMPHwvy-2Dr*8$Xb7(ZNhG}E`vxn.-9' );
define( 'NONCE_SALT',       'ebhKrrv=pZCw4Eb=&*/2*oM4BjeP%_zYb%{7,9DwoG<Yg9h?O3Q6.~.9<jm/_Xk2' );
/**#@-*/

/**
 * WordPress veritabanı tablo ön eki.
 *
 * Tüm kurulumlara ayrı bir önek vererek bir veritabanına birden fazla kurulum yapabilirsiniz.
 * Sadece rakamlar, harfler ve alt çizgi lütfen.
 */
$table_prefix = 'quzy_';

/**
 * Geliştiriciler için: WordPress hata ayıklama modu.
 *
 * Bu değeri "true" yaparak geliştirme sırasında hataların ekrana basılmasını sağlayabilirsiniz.
 * Tema ve eklenti geliştiricilerinin geliştirme aşamasında WP_DEBUG
 * kullanmalarını önemle tavsiye ederiz.
 */
define('WP_DEBUG', false);
define('COMPRESS_SCRIPTS', true);
define('COMPRESS_CSS', true);

/* Hepsi bu kadar. Mutlu bloglamalar! */

/** WordPress dizini için mutlak yol. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** WordPress değişkenlerini ve yollarını kurar. */
require_once(ABSPATH . 'wp-settings.php');
