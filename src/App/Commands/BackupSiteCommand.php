<?php
namespace Console\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class BackupSiteCommand extends Command
{
    protected function configure()
    {
        $this->setName("site")
                ->setHelp("site site_id site_path profile bucket_name [include] [exclude]
                                    site_id=if you have many sites
                                    site_root=site path
                                    profile=aws user profile
                                    bucket_name=aws bucket which used for backup")
                ->setDescription('used for backup sites')
                ->addArgument("site_id",InputArgument::REQUIRED,"write your site id")
                ->addArgument("site_root",InputArgument::REQUIRED,"write site path")
                ->addArgument("profile",InputArgument::REQUIRED,"write your aws profile")
                ->addArgument("bucket_name",InputArgument::REQUIRED,"write your aws bucket name");
//                ->addArgument("include",InputArgument::IS_ARRAY | InputArgument::OPTIONAL,"write directories to include")
//                ->addArgument("exclude",InputArgument::IS_ARRAY | InputArgument::OPTIONAL,"write directories to exclude");

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $site_id=$input->getArgument("site_id");
        $sites_storage_local_path_root="/backup_sites";
        $site_root = $input->getArgument("site_root")."/storage";
        $backup_dir_local_path = $sites_storage_local_path_root."/".$site_id;
        $aws_config_file_profile = $input->getArgument("profile");
        $bucket_name = $input->getArgument("bucket_name");
        ##################################################################################################################
        $output->writeln('<comment>Site backup locally...'.date("Y/m/d H:i:s").'</comment>');
        if(! is_dir($sites_storage_local_path_root) ){
            system("mkdir ".$sites_storage_local_path_root);
            system("chmod 777 -R ".$sites_storage_local_path_root);
        }
        if(! is_dir($backup_dir_local_path) ){
            system("mkdir ".$backup_dir_local_path);
            system("chmod 777 -R ".$backup_dir_local_path);
        }
        ##################################################################################################################
        system("rsync -av --delete ".$site_root." ".$backup_dir_local_path);
        system("chmod -R 777 ".$sites_storage_local_path_root);
        ##################################################################################################################
        $output->writeln('<comment>Site backup on S3...</comment>');
        system("/snap/bin/aws s3 sync --delete ".$backup_dir_local_path." s3://".$bucket_name."/backup_sites/".$site_id." --profile ".$aws_config_file_profile);
        ##################################################################################################################
        $output->writeln("Site backup done successfully.".date("Y/m/d H:i:s")."\n\n");

        return 0;
    }
}