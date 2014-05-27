# config valid only for Capistrano 3.1
lock '3.1.0'

set :application, 'cooktimesaver'
set :repo_url, 'https://github.com/nfqakademija/cooktimesaver.git'

set :deploy_to, '/home/cooktimesaver/public_html'
set :linked_files, %w{app/config/parameters.yml}
set :linked_dirs, %w{app/logs vendor}
set :keep_releases, 5

namespace :deploy do

  before :publishing, :restart

  before :restart, :clear_cache do
    on roles(:web) do
        execute "cd #{release_path} && composer install"
    end
  end
  after :finishing, 'deploy:cleanup'
end