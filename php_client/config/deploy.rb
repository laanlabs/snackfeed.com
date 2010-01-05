set :application, "smoothtube"
set :domain, "kortina.net"
set :user, "kortina"
set :checkout, "export"

set :scm_password, "hijkl8"

set :repository, " svn+ssh://egina@egina.kortina.net/home/egina/svn/eginacorp/#{application}"
set :deploy_to, "/home/kortina/apps/#{application}" # This is where your project will be deployed.


role :app, domain
role :web, domain
# role :db,  "mysql.#{domain}", :primary => true

depend :remote, :directory, deploy_to

namespace :deploy do
  
  # Also overwritten to remove Rails-specific code.
  task :finalize_update, :except => { :no_release => true } do
    run "chmod -R g+w #{release_path}" if fetch(:group_writable, true)
  end
  
  # Each of the following tasks are Rails specific. They're removed.
  task :migrate do
  end
  
  task :migrations do
  end
  
  task :cold do
  end
  
  task :start do
  end
  
  task :stop do
  end

  # Do nothing (To restart apache, run 'cap deploy:apache:restart')
  task :restart do
  end
end