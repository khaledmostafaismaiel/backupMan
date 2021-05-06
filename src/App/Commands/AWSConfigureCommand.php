<?php
namespace Console\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Console\App\Commands\Helper;
class AWSConfigureCommand extends Command
{
    protected function configure()
    {
        $this->setName("aws:configure")
                ->setHelp("aws:configure key secret region output profile")
                ->setDescription('used for configure aws cli creadintailas')
                ->addArgument("key",
                            InputArgument::REQUIRED,
                            "write aws key"
                            )
                ->addArgument("secret",
                            InputArgument::REQUIRED,
                            "write aws secret"
                            )
                ->addArgument("region",
                            InputArgument::REQUIRED,
                            "write aws region"
                            )
                ->addArgument("output",
                            InputArgument::REQUIRED,
                            "write aws output format"
                            )
                ->addArgument("profile",
                            InputArgument::REQUIRED,
                            "write aws profile"
                        );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fake_aws_dir_path = "/home/khaled/aws";
        $fake_aws_config_path = "/home/khaled/aws/config";
        $fak_aws_creadentials_path = "/home/khaled/aws/credentials";
        $aws_profile=$input->getArgument("profile");
        $aws_region=$input->getArgument("region");
        $aws_output=$input->getArgument("output");
        $aws_key=$input->getArgument("key");
        $aws_secret=$input->getArgument("secret");

        Helper::deleteDirectory("/home/khaled/aws");

        if(! is_dir("/home/khaled/.aws") ){
            system("mkdir ".$fake_aws_dir_path);
            system("chmod 777 -R ".$fake_aws_dir_path);
        }else{
            system("chmod 777 -R ".$fake_aws_dir_path);
            Helper::copyDirectory("/home/khaled/.aws","/home/khaled/aws");
        }

        if(! file_exists($fake_aws_config_path) ){
            system("touch ".$fake_aws_config_path);
            system("chmod 777 -R ".$fake_aws_dir_path);
        }else{
            system("chmod 777 -R ".$fake_aws_dir_path);
        }

        $line_number = Helper::getLineNumber($fake_aws_config_path,$aws_profile);
        if($line_number != -1 ){
            Helper::deleteContentOccuranceByLineNumber($fake_aws_config_path, $line_number);
            Helper::deleteContentOccuranceByLineNumber($fake_aws_config_path, $line_number);
            Helper::deleteContentOccuranceByLineNumber($fake_aws_config_path, $line_number);
        }
        
        Helper::contentToFile("[".$aws_profile."]\n",$fake_aws_config_path,"a");
        Helper::contentToFile("region = ".$aws_region."\n",$fake_aws_config_path,"a");
        Helper::contentToFile("output = ".$aws_output."\n",$fake_aws_config_path,"a");


        if(! is_dir($fak_aws_creadentials_path) ){
            system("touch ".$fak_aws_creadentials_path);
            system("chmod 777 -R ".$fake_aws_dir_path);
        }else{
            system("chmod 777 -R ".$fake_aws_dir_path);
        }

        $line_number = Helper::getLineNumber($fak_aws_creadentials_path,$aws_profile);
        if($line_number != -1 ){
            Helper::deleteContentOccuranceByLineNumber($fak_aws_creadentials_path, $line_number);
            Helper::deleteContentOccuranceByLineNumber($fak_aws_creadentials_path, $line_number);
            Helper::deleteContentOccuranceByLineNumber($fak_aws_creadentials_path, $line_number);
        }
        
        Helper::contentToFile("[".$aws_profile."]\n",$fak_aws_creadentials_path,"a");
        Helper::contentToFile("aws_secret_access_key = ".$aws_key."\n",$fak_aws_creadentials_path,"a");
        Helper::contentToFile("aws_access_key_id = ".$aws_secret."\n",$fak_aws_creadentials_path,"a");

        Helper::deleteDirectory("/home/khaled/.aws");

        Helper::moveDirectory("/home/khaled/aws","/home/khaled/.aws");

        return 0;
    }
}