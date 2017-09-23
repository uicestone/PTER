# 总体架构
![bingo training](https://user-images.githubusercontent.com/2181611/30770226-89d069d2-a05d-11e7-8e2d-7dd594f590fc.png)


站点资产包括：域名、服务器和CDN、程序代码、配置文件，上传文件和数据库，下面依次介绍：

# 域名
- 域名在Godaddy注册，通过账号密码登录管理
- 域名由Godaddy负责解析，其中最重要的为将根域名和www子域名解析到大陆和澳洲服务器的A记录
- 域名续费费用目前由Bingo Training负担

# 服务器和CDN
- Google Cloud Platform：Bingo Training企业账号，目前由Uice Lu管理并负担费用，使用的主要服务包括一台服务器pter-au-1（包含一个固定IP），一个负载平衡器pter-cdn（包含一个固定IP）和一个存储pter-storage
- 阿里云：Bingo Training企业账号，目前由Uice Lu管理，由Bingo Training负担费用，使用的主要服务为一台服务器pter-cn-1（包含一个固定IP）
- 七牛云：Uice Lu个人账号，使用的主要服务为一个大陆CDN加速域名和一个CDN存储，由Uice Lu负担费用
- 可以使用SSH的方式访问GCP和阿里云服务器（需在服务器上开设账号）：在终端输入 `ssh <username>@bingotraining.com` 或者 `ssh <username>@cn.bingotraining.com`

# 程序代码
- 站点资产所有代码，以及代码的所有历史版本，使用git版本仓库管理，并由Github保管
- 所有人可以在
 https://github.com/uicestone/PTER 查看站点的历史代码、历史修改记录、所有Issue以及Milestone，但不包括任何敏感信息（站点配置、上传文件和数据库）
- 若需要修改仓库（提交代码、关闭Issue、修改Milestone），需要登录Github，并获得该仓库Collaborator权限
- 最新版本的程序代码被部署到pter-au-1服务器上，部署位置/var/www/pter
- Github免费托管开源程序代码

# 配置文件
- 配置文件位于部署位置的/wp-config.php，包含数据库密码，API Key等关键信息。只有服务器root权限才能查看修改。

# 上传文件
- 上传文件位于部署位置的/wp-content/uploads/包括站点内容中用到的所有图片、音频、视频等（特别大的视频会被单独放到GCP存储）

部署的最新版本程序代码、配置文件和上传文件**每日**会被增量同步到pter-cn-1的/var/backups/pter

# 数据库
- 数据库包含了网站所有的用户、内容和订单等信息，目前部署在pter-au-1上
- 数据库每小时自动备份到pter-au-1的/var/backups
- pter-au-1上的数据库备份文件每天被同步到pter-cn-1
