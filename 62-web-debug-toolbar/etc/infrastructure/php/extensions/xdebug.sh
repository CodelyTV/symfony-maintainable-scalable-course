git clone --depth 1 --branch 3.0.4 https://github.com/xdebug/xdebug.git
cd xdebug
git checkout 592ab9fa10cfa132623489511e92ef69fb91744c
phpize
./configure
make
make install
