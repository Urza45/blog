# PHP P5 Openclassrooms Create your first blog in PHP

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/87b549702aff4c0d989d47a2cebd4465)](https://app.codacy.com/gh/Urza45/blog?utm_source=github.com&utm_medium=referral&utm_content=Urza45/blog&utm_campaign=Badge_Grade_Settings)

## Create a new repository on the command line
  
echo "# blog" >> README.md  
git init  
git add README.md  
git commit -m "first commit"  
git branch -M main  
git remote add origin <https://github.com/Urza45/blog.git>  
git push -u origin main  
  
## Push an existing repository from the command line
  
git remote add origin <https://github.com/Urza45/blog.git>  
git branch -M main  
git push -u origin main  

If you don't have it, install Composer: <https://getcomposer.org/download/>

Add third-party extensions with Composer : composer:install

Modify the config/config.model.php file and rename it to config.php

Use files from the diagrams/database directory to create the MySQL database (Version 5.7.31)
Default user created: ADMIN, password ADMIN, super administrator level
