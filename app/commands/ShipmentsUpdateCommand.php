<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Backend\Model\Payment;
use Backend\Controller\UPSCourrier;

/**
 * Class ShipmentsUpdateCommand
 */
class ShipmentsUpdateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'shipments:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Aggiorna lo stato dei shipment';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function fire()
	{

        $payments = Payment::
            whereNotNull('trackingcode')
            ->where(function($query){
                $query->where('shipmentStatus','!=','DELIVERED')
                    ->whereNull('shipmentStatus','or');
            })
            ->get();

		foreach($payments as $payment){
            $ups = new UPSCourrier($payment->trackingcode);

            if(!is_null($ups->signedBy) ) {
                $payment->signedby = $ups->signedBy;
            }

            $payment->shipmentStatus = $ups->currentStatus;

            $payment->save();
        }

        //se è tutto ok, lo memorizzo nell'history del cron job
        $jobHistory = new \Backend\Model\JobHistory(['result' => 1]);
        $cronJob = \Backend\Model\Cronjob::where('name','=','shipments_update')->first();
        $cronJob->histories()->save($jobHistory);

        
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::OPTIONAL, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
