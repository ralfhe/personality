<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\v1;

use TUM\Ventureinitiative\TestBundle\Wizard\TestInterface;
use TUM\Ventureinitiative\TestBundle\Wizard\GenericStep;
use TUM\Ventureinitiative\TestBundle\TUMVentureinitiativeTestBundle;

class Big5v1 implements TestInterface {
	
	private $resultView = null;
	private $steps;
	private $stepCount;
	
	public function __construct() {
		
		$this->steps = array();
		
		$step1FormType = 'TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\v1\FormTypes\Step1Type';
		$step1 = new GenericStep('Step 1', '@test_view\Big5\v1\Views\step.html.twig', new $step1FormType, false);
		$this->steps[] = $step1;
		
		$step2FormType = 'TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\v1\FormTypes\Step2Type';
		$step2 = new GenericStep('Step 2', '@test_view\Big5\v1\Views\step.html.twig', new $step2FormType, false);
		$this->steps[] = $step2;

		$uniqueStep1FormType = 'TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\v1\FormTypes\UniqueStep1Type';
		$uniqueStep1 = new GenericStep('Unique Step 1', '@test_view\Big5\v1\Views\uniqueStep.html.twig', new $uniqueStep1FormType, true);
		$this->steps[] = $uniqueStep1;
		
		$this->resultView = '@test_view\Big5\v1\Views\result.html.twig';
		$this->setStepCount();
		
	}
	
	public function getSteps() {
		return $this->steps;
	}
	
	private function setStepCount() {
		
		$steps = 0;
		$uniqueSteps = 0;
		
		foreach($this->getSteps() as $aStep) {
			if($aStep->isUnique()) {
				$uniqueSteps++;
			}
			else {
				$steps++;
			}
		}
		
		$this->stepCount = array('total' => count($this->getSteps()), 'steps' => $steps, 'uniqueSteps' => $uniqueSteps);
		
	}
	
	public function getStepCount() {
		return $this->stepCount;
	}
	
	public function evaluate($formData) {
		
		$answers = array();
		
		for ($i = 0; $i <= $this->getStepCount()['steps'] - 1; $i++) {
			$answers = array_merge($answers, array_values($formData[$i]));
		}
		
		$reverseItems = array(5,20,30,1,11,26,36,7,17,22,42,8,23,33,34,40);
		
		foreach($reverseItems as $reversedItem) {
			$answers[$reversedItem] = 6 - $answers[$reversedItem];
		}
		
		$extraversionItems = array(0,5,10,15,20,25,30,35);
		$extraversion = 0;
		foreach ($extraversionItems as $extraversionItem) {
			$extraversion = $extraversion + $answers[$extraversionItem];
		}
		$extraversion = $extraversion/count($extraversionItems);
		
		$agreeablenessItems = array(1,6,11,16,21,26,31,36,41);
		$agreeableness = 0;
		foreach ($agreeablenessItems as $agreeablenessItem) {
			$agreeableness = $agreeableness + $answers[$agreeablenessItem];
		}
		$agreeableness = $agreeableness/count($agreeablenessItems);
		
		$conscientiousnessItems = array(2,7,12,17,22,27,32,37,42);
		$conscientiousness = 0;
		foreach ($conscientiousnessItems as $conscientiousnessItem) {
			$conscientiousness = $conscientiousness + $answers[$conscientiousnessItem];
		}
		$conscientiousness = $conscientiousness/count($conscientiousnessItems);
		
		$neuroticismItems = array(3,8,13,18,23,28,33,38);
		$neuroticism = 0;
		foreach ($neuroticismItems as $neuroticismItem) {
			$neuroticism = $neuroticism + $answers[$neuroticismItem];
		}
		$neuroticism = $neuroticism/count($neuroticismItems);
		
		$opennessItems = array(4,9,14,19,24,29,34,39,40,43);
		$openness = 0;
		foreach ($opennessItems as $opennessItem) {
			$openness = $openness + $answers[$opennessItem];
		}
		$openness = $openness/count($opennessItems);
		
		$evaluation = array(
				'extraversion' => round($extraversion,2),
				'agreeableness' => round($agreeableness,2),
				'conscientiousness' => round($conscientiousness,2),
				'neuroticism' => round($neuroticism,2),
				'openness' => round($openness,2));
		
		return $evaluation;
		
	}
	
	public function calculateResult($data) {
		
		$referenceData = $this->csv_to_array('../src/TUM/Ventureinitiative/TestBundle/Wizard/Tests/Big5/v1/big5.csv')[$data['uniqueSteps'][0]['age']];
		
		$charts['extraversion'] = $this->calculateGraphUrl($data['evaluation']['self']['extraversion'], 0, $referenceData['E'], $referenceData['ESD']); 
		$charts['agreeableness'] = $this->calculateGraphUrl($data['evaluation']['self']['agreeableness'], 0, $referenceData['O'], $referenceData['ASD']);
		$charts['conscientiousness'] = $this->calculateGraphUrl($data['evaluation']['self']['conscientiousness'], 0, $referenceData['C'], $referenceData['CSD']);
		$charts['neuroticism'] = $this->calculateGraphUrl($data['evaluation']['self']['neuroticism'], 0, $referenceData['N'], $referenceData['NSD']);
		$charts['openness'] = $this->calculateGraphUrl($data['evaluation']['self']['openness'], 0, $referenceData['O'], $referenceData['OSD']);
		
		 return array(
		 	'evaluation' => $data['evaluation'],
		 	'referenceEvaluation' => $referenceData,
		 	'groupEvaluation' => null,
		 	'charts' => $charts 
		 );
		
	}
	
	public function getResultView() {
		return $this->resultView;
	}
	
	private function norm($x, $mean, $sd) {
		return (1 / ($sd * sqrt(2 * M_PI))) * exp(-0.5*pow(($x-$mean)/$sd,2));
	}
	
	private function calculateGraphUrl($personal, $group, $mean, $sd){
		$chartUrl =  '<img src="//chart.googleapis.com/chart?chxr=0,1,5|1,0,0&chxs=0,676767,12,0,lt,676767|1,676767,0,0,_,676767&chxt=x,y&chs=500x250&cht=lxy&chco=3a87ad,b94a48,468847,f89406&chds=1,5,0,0.7,1,5,0,0.7,1,5,0,0.7,1,5,0,0.7&chd=t:';
		
		for ($i = 1; $i < 5; $i += 0.1) {
			$chartUrl .= $i.',';
		}
		
		$chartUrl .= '5|';
		
		for ($i = 1.0; $i < 5; $i=$i+0.1) {
			$chartUrl .= $this->norm($i, $mean, $sd).',';
		}
		
		$chartUrl .= $this->norm(5, $mean, $sd).'|';
		$chartUrl .= $personal.','.$personal;
		$chartUrl .= '|0,0.7|';
		$chartUrl .= $group.','.$group;
		$chartUrl .= '|0,0.7|';
		$chartUrl .= (float)$mean.','.(float)$mean;
		$chartUrl .= '|0,0.7&chls=3|2|2|1,5,5&chma=5,5,5,10|0,10&chm=B,BBCCED,0,0,0" width="500" height="250" alt="" />';
		
		return $chartUrl;
	}
	
	private function csv_to_array($filename='', $delimiter=',')
	{
		if(!file_exists($filename) || !is_readable($filename))
			return FALSE;
		
		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE)
			{
				if(!$header) {
					$header = $row;
				}
				else {
					$data[$row[0]] = array_combine($header, $row);
				}
				
			}
			fclose($handle);
		}
		return $data;
	}
	
}