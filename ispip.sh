#!/bin/bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH
# this scrip write by Clang at 2014-08-12.
# discriminate per isp from apnic.

# define save ip result directory.
save_dir="./wp-content/cache/ispip"

# download ip info from apnic website.
apnic_ip_info="$save_dir/apnic_ip_info"

# get all ip list values from apnic.
apnic_all_ip="$save_dir/apnic_all_ip"


if [ ! -d "$save_dir" ]; then
mkdir "$save_dir"
fi

# delete old exist file.
if [ -e "$apnic_ip_info" ];then
rm -f $apnic_ip_info
fi

if [ -e "$apnic_all_ip" ];then
rm -f $apnic_all_ip
fi

wget -q https://ftp.apnic.net/apnic/stats/apnic/delegated-apnic-latest -O $apnic_ip_info

grep "apnic|CN|ipv4|" "$apnic_ip_info" | awk -F'|' '{print $4"/"$5}' > "$apnic_all_ip"
sed -i 's:/1$:/255.255.255.255:g' "$apnic_all_ip"
sed -i 's:/2$:/255.255.255.254:g' "$apnic_all_ip"
sed -i 's:/4$:/255.255.255.252:g' "$apnic_all_ip"
sed -i 's:/8$:/255.255.255.248:g' "$apnic_all_ip"
sed -i 's:/16$:/255.255.255.240:g' "$apnic_all_ip"
sed -i 's:/32$:/255.255.255.224:g' "$apnic_all_ip"
sed -i 's:/64$:/255.255.255.192:g' "$apnic_all_ip"
sed -i 's:/128$:/255.255.255.128:g' "$apnic_all_ip"
sed -i 's:/256$:/255.255.255.0:g' "$apnic_all_ip"
sed -i 's:/512$:/255.255.254.0:g' "$apnic_all_ip"
sed -i 's:/1024$:/255.255.252.0:g' "$apnic_all_ip"
sed -i 's:/2048$:/255.255.248.0:g' "$apnic_all_ip"
sed -i 's:/4096$:/255.255.240.0:g' "$apnic_all_ip"
sed -i 's:/8192$:/255.255.224.0:g' "$apnic_all_ip"
sed -i 's:/16384$:/255.255.192.0:g' "$apnic_all_ip"
sed -i 's:/32768$:/255.255.128.0:g' "$apnic_all_ip"
sed -i 's:/65536$:/255.255.0.0:g' "$apnic_all_ip"
sed -i 's:/131072$:/255.254.0.0:g' "$apnic_all_ip"
sed -i 's:/262144$:/255.252.0.0:g' "$apnic_all_ip"
sed -i 's:/524288$:/255.248.0.0:g' "$apnic_all_ip"
sed -i 's:/1048576$:/255.240.0.0:g' "$apnic_all_ip"
sed -i 's:/2097152$:/255.224.0.0:g' "$apnic_all_ip"
sed -i 's:/4194304$:/255.192.0.0:g' "$apnic_all_ip"
sed -i 's:/8388608$:/255.128.0.0:g' "$apnic_all_ip"
sed -i 's:/16777216$:/255.0.0.0:g' "$apnic_all_ip"
sed -i 's:/33554432$:/254.0.0.0:g' "$apnic_all_ip"
sed -i 's:/67108864$:/252.0.0.0:g' "$apnic_all_ip"
sed -i 's:/134217728$:/248.0.0.0:g' "$apnic_all_ip"
sed -i 's:/268435456$:/240.0.0.0:g' "$apnic_all_ip"
sed -i 's:/536870912$:/224.0.0.0:g' "$apnic_all_ip"
sed -i 's:/1073741824$:/192.0.0.0:g' "$apnic_all_ip"
sed -i 's:/2147483648$:/128.0.0.0:g' "$apnic_all_ip"
sed -i 's:/4294967296$:/0.0.0.0:g' "$apnic_all_ip"

sed -i 's:/255.255.255.255$:/32:g' "$apnic_all_ip"
sed -i 's:/255.255.255.254$:/31:g' "$apnic_all_ip"
sed -i 's:/255.255.255.252$:/30:g' "$apnic_all_ip"
sed -i 's:/255.255.255.248$:/29:g' "$apnic_all_ip"
sed -i 's:/255.255.255.240$:/28:g' "$apnic_all_ip"
sed -i 's:/255.255.255.224$:/27:g' "$apnic_all_ip"
sed -i 's:/255.255.255.192$:/26:g' "$apnic_all_ip"
sed -i 's:/255.255.255.128$:/25:g' "$apnic_all_ip"
sed -i 's:/255.255.255.0$:/24:g' "$apnic_all_ip"
sed -i 's:/255.255.254.0$:/23:g' "$apnic_all_ip"
sed -i 's:/255.255.252.0$:/22:g' "$apnic_all_ip"
sed -i 's:/255.255.248.0$:/21:g' "$apnic_all_ip"
sed -i 's:/255.255.240.0$:/20:g' "$apnic_all_ip"
sed -i 's:/255.255.224.0$:/19:g' "$apnic_all_ip"
sed -i 's:/255.255.192.0$:/18:g' "$apnic_all_ip"
sed -i 's:/255.255.128.0$:/17:g' "$apnic_all_ip"
sed -i 's:/255.255.0.0$:/16:g' "$apnic_all_ip"
sed -i 's:/255.254.0.0$:/15:g' "$apnic_all_ip"
sed -i 's:/255.252.0.0$:/14:g' "$apnic_all_ip"
sed -i 's:/255.248.0.0$:/13:g' "$apnic_all_ip"
sed -i 's:/255.240.0.0$:/12:g' "$apnic_all_ip"
sed -i 's:/255.224.0.0$:/11:g' "$apnic_all_ip"
sed -i 's:/255.192.0.0$:/10:g' "$apnic_all_ip"
sed -i 's:/255.128.0.0$:/9:g' "$apnic_all_ip"
sed -i 's:/255.0.0.0$:/8:g' "$apnic_all_ip"
sed -i 's:/254.0.0.0$:/7:g' "$apnic_all_ip"
sed -i 's:/252.0.0.0$:/6:g' "$apnic_all_ip"
sed -i 's:/248.0.0.0$:/5:g' "$apnic_all_ip"
sed -i 's:/240.0.0.0$:/4:g' "$apnic_all_ip"
sed -i 's:/224.0.0.0$:/3:g' "$apnic_all_ip"
sed -i 's:/192.0.0.0$:/2:g' "$apnic_all_ip"
sed -i 's:/128.0.0.0$:/1:g' "$apnic_all_ip"
sed -i 's:/0.0.0.0$:/0:g' "$apnic_all_ip"
