<?php

namespace QSOBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use QSOBundle\Entity\Band;
use QSOBundle\Entity\FrequencyUnit;
use QSOBundle\Entity\RadioMode;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SetupCommand
 *
 * This command sets up the application for usage
 *
 * @package QSOBundle\Command
 */
class SetupCommand extends ContainerAwareCommand
{
    /** @var InputInterface */
    protected $input = null;

    /** @var OutputInterface */
    protected $output = null;

    /**3
     * Configure the console command
     */
    protected function configure()
    {
        $this
            ->setName('setup')
            ->setDescription('Install the base application *DO NOT RUN IN PRODUCTION*');
    }

    /**
     * Execute the console command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $output->writeln(array(
            '',
            'The system will now prepare the application for usage, please wait!',
            ''
        ));

        // Setup basic data lists
        $this->setupRadioModes();
        $this->setupFrequencyUnits();
        $this->setupBands();

        $output->writeln(array(
            '',
            'The system is done installing the application'
        ));
    }

    /**
     * Setup the radio modes in the database
     */
    protected function setupRadioModes()
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $modes = array(
            'USB',
            'LSB',
            'SSB',
            'CW',
            'FM',
            'AM',
            'RTTY',
            'ASCI',
            'ATV',
            'CLO',
            'FAX',
            'FSK',
            'GTOR',
            'HELL',
            'HFSK',
            'JT44',
            'MFSK8',
            'MFSK16',
            'MTTY',
            'MT63',
            'PAC',
            'PAC2',
            'PAC3',
            'PCW',
            'PKT',
            'PSK31',
            'PSK63',
            'PSK125',
            'Q15',
            'SSTV',
            'THRB',
            'TOR',
            'OLIVIA',
            'ROS',
            'AMTORFEC',
            'CHIP64',
            'CHIP128',
            'CONTESTI',
            'DSTAR',
            'DOMINO',
            'DOMINOF',
            'FMHELL',
            'FSK31',
            'FSK441',
            'HELL80',
            'JT65',
            'JT65A',
            'JT6m',
            'PAX',
            'PAX2',
            'PSK10',
            'PSK63F',
            'PSKAM10',
            'PSKAM31',
            'PSKAM50',
            'PSKFEC31',
            'PSKHELL',
            'QPSK31',
            'QPSK63',
            'QPSK125',
            'RTTYM',
            'THOR',
            'THRBX',
            'VOI',
            'JT9',
            'JT9-1',
            'JT9-2',
            'JT65B',
            'JT65C'
        );

        foreach($modes as $mode)
        {
            $entity = new RadioMode();
            $entity->setMode($mode);
            $em->persist($entity);
        }

        $em->flush();

        $this->output->writeln('[ OK ] Installing basic radio modes..');
    }

    /**
     * Setup the frequency units
     */
    protected function setupFrequencyUnits()
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $units = array(
            'Hz',
            'Khz',
            'Mhz'
        );

        foreach($units as $unit)
        {
            $entity = new FrequencyUnit();
            $entity->setUnit($unit);
            $em->persist($entity);
        }

        $em->flush();

        $this->output->writeln('[ OK ] Installing frequency units..');
    }

    /**
     * Setup the radio bands
     */
    protected function setupBands()
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $bands = array(
            '160 m',
            '80 m',
            '60 m',
            '40 m',
            '30 m',
            '20 m',
            '17 m',
            '15 m',
            '12 m',
            '10 m',
            '6 m',
            '2 m',
            '1.25 m',
            '70 cm',
            '33 cm',
            '23 cm',
            '13 cm',
            '5 cm',
            '3 cm'
        );

        foreach ($bands as $band)
        {
            $entity = new Band();
            $entity->setBand($band);
            $em->persist($entity);
        }

        $em->flush();

        $this->output->writeln('[ OK ] Installing frequency units..');
    }
}
