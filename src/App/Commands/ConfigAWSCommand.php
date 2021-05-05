<?php
namespace Console\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigAWSCommand extends Command
{
    protected function configure()
    {
        $this->setName("config:aws")
                ->setHelp("config:aws")
                ->setDescription('used for config AWS CLI config and credentials.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $aws_config_file_profile=0;
        $aws_config_file_region=0;
        $aws_config_file_output=0;
        $aws_credentials_file_profile=0;
        $aws_credentials_file_access_key_id=0;
        $aws_credentials_file_secret_access_key=0;
/*
        system("rm -rf ~/aws");
        system("cp -rp ~/.aws ~/aws");
        system("chmod 777 ~/aws");

        system("touch ~/aws/config");
        system("chmod 777 ~/aws");
        $line_number = $this->getLineNumber(storage_path("config"),$aws_config_file_profile);
        if($line_number != -1 ){
        $this->deleteContentOccuranceByLineNumber(storage_path("config"), $line_number);
        $this->deleteContentOccuranceByLineNumber(storage_path("config"), $line_number);
        $this->deleteContentOccuranceByLineNumber(storage_path("config"), $line_number);
        }

        $this->contentToFile("[".$aws_config_file_profile."]\n",storage_path("config"),"a");
        $this->contentToFile("region = ".$aws_config_file_region."\n",storage_path("config"),"a");
        $this->contentToFile("output = ".$aws_config_file_output."\n",storage_path("config"),"a");

        system("touch ~/aws/credentials");
        system("chmod 777 ~/aws");
        $line_number = $this->getLineNumber(storage_path("credentials"),$aws_credentials_file_profile);
        if($line_number != -1 ){
        $this->deleteContentOccuranceByLineNumber(storage_path("credentials"), $line_number);
        $this->deleteContentOccuranceByLineNumber(storage_path("credentials"), $line_number);
        $this->deleteContentOccuranceByLineNumber(storage_path("credentials"), $line_number);
        }

        $this->contentToFile("[".$aws_config_file_profile."]\n",storage_path("credentials"),"a");
        $this->contentToFile("aws_secret_access_key = ".$aws_credentials_file_access_key_id."\n",storage_path("credentials"),"a");
        $this->contentToFile("aws_access_key_id = ".$aws_credentials_file_secret_access_key."\n",storage_path("credentials"),"a");


        $this->deleteDirectoryFromServer("~/.aws");

        $this->runCommand("mv ~/aws ~/.aws");
        $this->runCommand("chmod 777 ~/.aws");
*/
        return 0;
    }

}