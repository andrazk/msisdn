class php {

  file { '/etc/apt/apt.conf.d/99auth':
    owner => root,
    group => root,
    content => 'APT::Get::AllowUnauthenticated yes;',
    mode =>644;
  }

  exec { 'add-repo':
    command => 'add-apt-repository ppa:ondrej/php5-5.6',
    path => '/usr/bin',
    require => File['/etc/apt/apt.conf.d/99auth']
  }

  exec { 'update-first':
    command => 'apt-get update',
    path => '/usr/bin',
    require => Exec['add-repo'],
  }

  package { 'python-software-properties':
    ensure => present,
    require => Exec['update-first'],
  }

  exec { 'update-second':
    command => 'apt-get update',
    path => '/usr/bin',
    require => Package['python-software-properties'],
  }

  package { 'php5':
    ensure => present,
    install_options => ['--allow-unauthenticated', '-f'],
    require => Exec['update-second'],
  }

  package { 'php5-intl':
    ensure => installed,
    require => Package['php5'],
  }
}
