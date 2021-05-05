<?php
namespace Console\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class RestoreDatabaseCommand extends Command
{
    protected function configure()
    {
        $this->setName("restore-database")
                ->setHelp("database server_id user password profile bucket_name at profile
                                    server_id=if you have many servers
                                    user=mysql user name if type [1,3]
                                    password=mysql user password if type [1,3]
                                    bucket_name=aws bucket which used for backup
                                    at=vetsioning time
                                    profile=aws user profile")
                ->setDescription('used for backup databases per user or all daabases in "/var/lib/" or for both')
                ->addArgument("server_id",InputArgument::REQUIRED,"write your server id")
                ->addArgument("mysql_user",InputArgument::REQUIRED,"write mysql user")
                ->addArgument("mysql_password",InputArgument::REQUIRED,"write mysql password")
                ->addArgument("bucket_name",InputArgument::REQUIRED,"write your aws bucket name")
                ->addArgument("at",InputArgument::REQUIRED,"write vetsioning time")
                ->addArgument("profile",InputArgument::REQUIRED,"write your aws profile");

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $server_id=$input->getArgument("server_id");
        $databases_storage_local_path_root="/restore_database";
        $aws_config_file_profile=$input->getArgument("profile");
        $bucket_name=$input->getArgument("bucket_name");
        $at=$input->getArgument("at");
        $restore_logs_directory = "/restore_logs";
        $restore_logs_file = $restore_logs_directory."/restore_log_database_".$server_id.".txt";
        ##################################################################################################################
        $output->writeln('<comment>Create logs directory "'.$restore_logs_directory.'"...'.date("Y/m/d H:i:s").'</comment>');
        if(! is_dir($restore_logs_directory) ){
            system("mkdir ".$restore_logs_directory);
            system("chmod 777 -R ".$restore_logs_directory);
        }
        ##################################################################################################################
        $output->writeln('<comment>Create staging directory "'.$databases_storage_local_path_root.'"...'.date("Y/m/d H:i:s").'</comment>');
        if(is_dir($databases_storage_local_path_root) ){
            system("rm -rf ".$databases_storage_local_path_root." >> ".$restore_logs_file);
        }
        if(! is_dir($databases_storage_local_path_root) ){
            system("mkdir ".$databases_storage_local_path_root." >> ".$restore_logs_file);
            system("chmod 777 -R ".$databases_storage_local_path_root." >> ".$restore_logs_file);
        }
        ##################################################################################################################
        $output->writeln('<comment>restore database from S3 ...."'.$databases_storage_local_path_root.'"...'.date("Y/m/d H:i:s").'</comment>');
        system("/usr/local/bin/s3-pit-restore -b ".$bucket_name." -d ".$databases_storage_local_path_root." -p database_backup -t '".$at."' --max-workers 100 >> ".$restore_logs_file);
        ##################################################################################################################
        $output->writeln("Database restore done successfully.".date("Y/m/d H:i:s")."\n\n");

        return 0;
    }
}