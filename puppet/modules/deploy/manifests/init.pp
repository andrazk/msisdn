class deploy {

    require php
    require composer

    file {'/home/vagrant/.composer':
        ensure => 'directory',
    }

    # Github OAuth token with access to public repos
    file { '/home/vagrant/.composer/auth.json':
        mode    => 644,
        content => '{"github-oauth": {"github.com": "53e1211c68f81c142f7d8b8ebe60fc59bcb930cb"}}',
    }

    # Install dependencies with composer
    exec { 'deploy-install':
        command => 'composer install',
        cwd => '/vagrant/server',
        environment => ['COMPOSER_HOME=/vagrant/server'],
        path =>  [ '/bin/', '/sbin/' , '/usr/bin/', '/usr/sbin/', '/usr/local/bin/' ],
        require => File['/home/vagrant/.composer/auth.json'],
    }

    # Run PHP web server
    exec { 'run-php-server':
        command => 'php -S localhost:8000 > log &',
        cwd => '/vagrant/server',
        path =>  [ '/bin/', '/sbin/' , '/usr/bin/', '/usr/sbin/', '/usr/local/bin/' ],
        require => Exec['deploy-install'],
    }
}
