class phpunit {

    require composer

    # exec { 'phpunit-install':
    #     command => 'composer global require "phpunit/phpunit=5.0.*"',
    #     path => [ '/bin/', '/sbin/' , '/usr/bin/', '/usr/sbin/', '/usr/local/bin/' ],
    #     environment => ['HOME=~/'],
    # }

    file { '/etc/profile.d/composer-path.sh':
        mode    => 644,
        content => 'PATH=$PATH:vagrant/server/vendor/bin/',
    }
}
