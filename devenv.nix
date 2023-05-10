{ pkgs, config, ... }:

let
  env = builtins.fromTOML(builtins.readFile ./.env.toml);
in

{
  packages = [ pkgs.git ];

  languages.php = {
    enable = true;
    version = "8.1";
    ini = ''
memory_limit = 256M
'';
    extensions = [
      "calendar"
      "curl"
      "openssl"
      "mbstring"
      "fileinfo"
      "intl"
      "apcu"
    ];

    fpm.pools.web = {
      settings = {
        "pm" = "dynamic";
        "pm.max_children" = 100;
        "pm.start_servers" = 50;
        "pm.min_spare_servers" = 25;
        "pm.max_spare_servers" = 100;
      };
    };
  };

  services.caddy.enable = true;
  services.caddy.virtualHosts."${env.web.localhost}" = {
    extraConfig = ''
      root * .
      php_fastcgi unix/${config.languages.php.fpm.pools.web.socket}
      file_server
    '';
  };

  # services.mysql.enable = true;
  # services.mysql.package = pkgs.mariadb;

  # services.mysql.initialDatabases = [
  #   {
  #     name = env.db.name;
  #     schema = ./${env.db.schema};
  #   }
  # ];

  # services.mysql.ensureUsers = [
  #   {
  #     name = env.db.user;
  #     password = env.db.pw;
  #     ensurePermissions = {
  #       "${env.db.name}.*" = "SELECT, UPDATE, INSERT, DELETE, ALTER, CREATE, INDEX, DROP, LOCK TABLES, USAGE";
  #     };
  #   }
  # ];

}
