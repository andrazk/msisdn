class deploy {

    require php
    require composer

    exec { 'deploy-install':
        command => 'composer install',
        cwd => '/vagrant/server',
        environment => ['COMPOSER_HOME=/vagrant/server'],
        path =>  [ '/bin/', '/sbin/' , '/usr/bin/', '/usr/sbin/', '/usr/local/bin/' ],
        #unless => 'test -e composer.lock'
    }

    # exec { 'deploy-update':
    #     command => 'composer update',
    #     cwd => '/vagrant/server',
    #     environment => ['COMPOSER_HOME=/vagrant/server'],
    #     path => [ '/bin/', '/sbin/' , '/usr/bin/', '/usr/sbin/', '/usr/local/bin/' ],
    #     onlyif => 'test -e composer.lock'
    # }
}
