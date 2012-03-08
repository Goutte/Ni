

Config is in sites/default/settings.php





OLD STUFF
=========

# RÉPARER UN RAGNAROK BDD

    php symfony cc
    php symfony doctrine:build --all
    php symfony doctrine:data-load data/fixtures

# PASSWORD FORGOTTEN OR WEIRDLY INVALID ?

    php symfony guard:change-password admin monP455Word


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
