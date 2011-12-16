# NINJA !

    php symfony cc
    php symfony doctrine:build --all
    php symfony doctrine:data-load data/fixtures
    php symfony cc

# .git/config

    [core]
      repositoryformatversion = 0
      filemode = true
      bare = false
      logallrefupdates = true
    [remote "origin"]
      url = git@github.com:Goutte/Ni.git
      fetch = +refs/heads/*:refs/remotes/origin/*
    [branch "master"]
      remote = origin
      merge = refs/heads/master
