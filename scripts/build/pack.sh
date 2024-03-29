
# Create variables
build_dir=$(pwd)
payload_dir=$build_dir/installer/payload

framework_location=remote
framework_branch=v3.1.2

# Clean up
rm -rf installer
rm -f com_cart_installer.zip
rm -f com_cart.zip
rm -f joomlatools-framework.zip

# build cart
phing

# build framework
cd ../../../joomlatools-framework && phing -Dframework.location=$framework_location -Dframework.branch=$framework_branch && mv joomlatools-framework.zip $build_dir/joomlatools-framework.zip
cd $build_dir

# clone installer
git clone --depth 1 --branch master git@github.com:joomlatools/joomlatools-extension-installer.git $build_dir/installer
rm -rf $build_dir/installer/.git
rm -f $build_dir/installer/.gitignore
rm -f $build_dir/installer/README.md
rm -f $build_dir/installer/LICENSE

# create payload
mkdir $payload_dir
cp manifest.json $payload_dir/manifest.json
unzip -q com_cart.zip -d $payload_dir/cart
unzip -q joomlatools-framework.zip -d $payload_dir/framework

# zip it all up
zip -q -r com_cart_installer.zip installer

# clean leftovers
rm -rf installer
rm -f com_cart.zip
rm -f joomlatools-framework.zip