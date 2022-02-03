<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'GPEA' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'pi' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'mjolnir' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ';)BSZ[Ks,n)Q8{n(q$op?dk;p7$<<WGN>v d91JNlmF68AD {+l*Oug<]LjDch?^' );
define( 'SECURE_AUTH_KEY',  '}`]z@/sAQl]U]RwzRWHw{xhpF!d)G,v,$4{8.p*@wb_tN{~[4n08L[n7}Oq5 |y>' );
define( 'LOGGED_IN_KEY',    'm5Z~LP{?rBHgh?%785TqSO[ *i GT}<UMp_5$MWa1Z]gdZ>~G;]]cCZMx?>ge0`y' );
define( 'NONCE_KEY',        'L5C9+9L)X.!D8@@xyXlPZOI/i K#V!wi%S-Ov zc!oM+&fCR,s2.svqVKLH(X2cj' );
define( 'AUTH_SALT',        't-/*[Nsr`}H;e[ {.zD]~vA(i9vdd=y<ank5S}Yl!swz_!>N8ZpIG}LEb;r6P 5a' );
define( 'SECURE_AUTH_SALT', '5,H]t!L.]e94}UL=D+K,g#~Ubz.pN/p-%,fL5x&fY+dB` MyN.z8HM%F/db6ri0t' );
define( 'LOGGED_IN_SALT',   '0jCRa8C_>GAY/6NjER4CQH=<%9Fns_Tc%~i>~53l_W:|X:*]5A01&UJ<)9y!W#Jp' );
define( 'NONCE_SALT',       ']vdRN5j-DZg WD}DS$uEV65^6uIEp7^oaB|+.NL;-(9d)N(54UFHt+VrKQ=5{k{n' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';

define( 'FS_METHOD', 'direct' );
