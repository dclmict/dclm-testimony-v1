## Install Make

### Mac
> To install make on mac, do the following:

##### Install [Xcode](https://developer.apple.com/xcode/)
> Xcode enables you to develop, test, and distribute apps for all Apple platforms

- open terminal and run
```sh
xcode-select --install
```

##### Install [Homebrew](https://developer.apple.com/xcode/)
> Homebrew is a package manager to install softwares on Mac.
- open terminal and run
```sh
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install.sh)"
```

##### Install [Make](https://www.gnu.org/software/make/)
-  open terminal and run
```sh
brew install make
brew info make
code ~/.bashrc
export PATH="/usr/local/opt/make/libexec/gnubin:$PATH"
source ~/.bashrc
make -v
```


### Linux
- make comes installed by default on most Linux distribution
- run `which make` to check
- run `make -v` to check installed version


### Windows
> To install make on windows, you need to go some extra mile

##### Install [Scoop](https://scoop.sh/)
> Scoop is a package manager for windows. 
- open a PowerShell terminal (version 5.1 or later) and run
```sh
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
```

##### Install [Make](https://www.gnu.org/software/make/)
> Make is a Build automation tool.
- open a PowerShell terminal (version 5.1 or later) and run
```sh
scoop install main/make
```
