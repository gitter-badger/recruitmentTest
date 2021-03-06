<?php
/**
 * This only for recruitment test purpose.
 *
 * @package   App
 * @author    Bambang Adrian S <bambang.adrian@gmail.com>
 * @copyright 2016 Proprietary Software
 * @license   No License
 * @link      https://github.com/bambangadrian/recruitmentTest
 */
namespace Project\App\Base\Model\Solutions;

/**
 * Class RecursiveMultiplication
 *
 * @package    App
 * @subpackage Base\Model\Solutions
 * @author     Bambang Adrian S <bambang.adrian@gmail.com>
 */
class RecursiveMultiplication extends \Project\App\Base\Model\AbstractBaseModel
{

    /**
     * Start number property.
     *
     * @var integer $StartNumber
     */
    private $StartNumber;

    /**
     * End number property.
     *
     * @var integer $EndNumber
     */
    private $EndNumber;

    /**
     * Step for decrement property.
     *
     * @var integer $Step
     */
    private $Step;

    /**
     * Calculation result property.
     *
     * @var float $CalculationResult
     */
    private $CalculationResult;

    /**
     * Result table property.
     *
     * @var array $ResultTable
     */
    private $ResultTable;

    /**
     * Calculated flag status.
     *
     * @var boolean $HasCalculated
     */
    private $HasCalculated = false;

    /**
     * Class constructor.
     *
     * @param integer $endNumber End number parameter.
     * @param integer $step      Step decrement number parameter.
     */
    public function __construct($endNumber = 10, $step = 3)
    {
        try {
            parent::__construct();
            $this->setStartNumber();
            $this->setEndNumber($endNumber);
            $this->setStep($step);
        } catch (\RuntimeException $e) {
            $this->setError($e->getMessage());
        }
    }

    /**
     * Do update model.
     *
     * @return boolean
     */
    public function doUpdate()
    {
        try {
            $this->setStartNumber($this->getPostValue('startNumber'));
            $this->setEndNumber($this->getPostValue('setEndNumber'));
            $this->setStep($this->getPostValue('step'));
            $this->doCalculate();
        } catch (\RuntimeException $e) {
            $this->setError($e->getMessage());
        }
        return true;
    }

    /**
     * Load model form.
     *
     * @return string
     */
    public function loadForm()
    {
        return 'solution2';
    }

    /**
     * Do the calculation.
     *
     * @param boolean $iterateEachNumber Iterate each number option parameter.
     *
     * @return void
     */
    public function doCalculate($iterateEachNumber = false)
    {
        # Check if the calculation has run, so its not double run.
        if ($this->isHasCalculated() === false) {
            $start = $this->getStartNumber();
            $end = $this->getEndNumber();
            $resultArr = [];
            if ($iterateEachNumber === true) {
                # Optimize the for loop without calling any function.
                for ($i = $start; $i <= $end; $i++) {
                    $resultArr[$i] = $this->recursiveMultiplication($i);
                }
            } else {
                $resultArr[$end] = $this->recursiveMultiplication($end);
            }
            $this->setCalculationResult($resultArr[$end]);
            $this->setResultTable($resultArr);
            $this->setHasCalculated(true);
        }
    }

    /**
     * Get start number property.
     *
     * @return integer
     */
    public function getStartNumber()
    {
        return $this->StartNumber;
    }

    /**
     * Set start number property.
     *
     * @param integer $startNumber Start number parameter.
     *
     * @throws \RuntimeException If invalid start number given.
     * @return void
     */
    public function setStartNumber($startNumber = 0)
    {
        if ($startNumber < 0) {
            throw new \RuntimeException('Invalid start number given, must be same or greater than 0');
        }
        # Do the hack checker on is integer checking.
        if ((integer)$startNumber != $startNumber or is_numeric($startNumber) === false) {
            throw new \RuntimeException('Start number must be an positive integer value');
        }
        # Set calculated flag to false if any change apply on start number value.
        if ($startNumber !== $this->getStartNumber()) {
            $this->setHasCalculated(false);
        }
        $this->StartNumber = $startNumber;
    }

    /**
     * Get end number property.
     *
     * @return integer
     */
    public function getEndNumber()
    {
        return $this->EndNumber;
    }

    /**
     * Set end number property.
     *
     * @param integer $endNumber End number parameter.
     *
     * @throws \RuntimeException If invalid end number given.
     * @return void
     */
    public function setEndNumber($endNumber)
    {
        if ($endNumber < 0) {
            throw new \RuntimeException('Invalid end number given, must be same or greater than 0');
        }
        # Do the hack checker on is integer checking.
        if ((integer)$endNumber != $endNumber or is_numeric($endNumber) === false) {
            throw new \RuntimeException('End number must be an positive integer value');
        }
        # Set calculated flag to false if any change apply on end number value.
        if ($endNumber !== $this->getEndNumber()) {
            $this->setHasCalculated(false);
        }
        $this->EndNumber = $endNumber;
    }

    /**
     * Get step number property.
     *
     * @return integer
     */
    public function getStep()
    {
        return $this->Step;
    }

    /**
     * Set step number property.
     *
     * @param integer $step Step number parameter.
     *
     * @throws \RuntimeException If invalid step number given.
     * @return void
     */
    public function setStep($step)
    {
        if ($step < 0) {
            throw new \RuntimeException('Invalid step number given, must be same or greater than 0');
        }
        # Do the hack checker on is integer checking.
        if ((integer)$step != $step or is_numeric($step) === false) {
            throw new \RuntimeException('Step number must be an positive integer value');
        }
        # Set calculated flag to false if any change apply on step number value.
        if ($step !== $this->getStep()) {
            $this->setHasCalculated(false);
        }
        $this->Step = $step;
    }

    /**
     * Get result table property.
     *
     * @return array
     */
    public function getResultTable()
    {
        $this->doCalculate();
        return $this->ResultTable;
    }

    /**
     * Set result table property.
     *
     * @param array $resultTable Result table data parameter.
     *
     * @return void
     */
    public function setResultTable($resultTable)
    {
        $this->ResultTable = $resultTable;
    }

    /**
     * Get calculated status flag property.
     *
     * @return boolean
     */
    public function isHasCalculated()
    {
        return $this->HasCalculated;
    }

    /**
     * Get recursive calculation result property.
     *
     * @return float
     */
    public function getCalculationResult()
    {
        $this->doCalculate();
        return $this->CalculationResult;
    }

    /**
     * Set calculated status flag property.
     *
     * @param boolean $calculated Calculated status flag parameter.
     *
     * @return void
     */
    protected function setHasCalculated($calculated)
    {
        $this->HasCalculated = $calculated;
    }

    /**
     * Set recursive calculation result property.
     *
     * @param float $calculationResult Calculation result parameter.
     *
     * @return void
     */
    protected function setCalculationResult($calculationResult)
    {
        $this->CalculationResult = $calculationResult;
    }

    /**
     * Recursive multiplication process.
     *
     * @param integer $recursiveNumber Next recursion number parameter.
     *
     * @return float.
     */
    private function recursiveMultiplication($recursiveNumber)
    {
        if ($recursiveNumber === 0) {
            return 1;
        } else {
            $nextNumber = $recursiveNumber - $this->getStep();
            if ($nextNumber < 0) {
                return $recursiveNumber;
            }
        }
        return $recursiveNumber * $this->recursiveMultiplication($nextNumber);
    }
}
