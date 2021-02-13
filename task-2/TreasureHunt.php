<?php

class TreasureHunt
{
    /**
     * Default maps
     * 
     * @var array
    */
    protected $map = [
        ['#', '#', '#', '#', '#', '#', '#', '#'],
        ['#', '.', '.', '.', '.', '.', '.', '#'],
        ['#', '.', '#', '#', '#', '.', '.', '#'],
        ['#', '.', '.', '.', '#', '.', '#', '#'],
        ['#', '.', '#', '.', '.', '.', '.', '#'],
        ['#', '#', '#', '#', '#', '#', '#', '#'],
    ];

    /**
     * Coordinate x
     * 
     * @var int
    */
    protected $x;

    /**
     * Coordinate y
     * 
     * @var int
    */
    protected $y;

    /**
     * Collection result position treasure
     * 
     * @var array
    */
    protected $result = [];

    /**
     * Tag player
     * 
     * @var string
    */
    protected const PLAYER = "X";

    /**
     * Tag hidden treasure
     * 
     * @var string
    */
    protected const HIDDEN_TREASURE = "1";

    /**
     * Tag position up
     * 
     * @var string
    */
    protected const UP = 'A';

    /**
     * Tag position down
     * 
     * @var string
    */
    protected const DOWN = 'C';

    /**
     * Tag position right
     * 
     * @var string
    */
    protected const RIGHT = 'B';

    /**
     * Tag position left
     * 
     * @var string
    */
    protected const LEFT = 'D';

    /**
     * The constructor
     * 
     * @return void
    */
    public function __construct()
    {
        //initial game random treasure and playe position
        $this->randomTreasure();
        $this->randomPlayerPosition();
    }

    /**
     * Print layout
     * 
     * @return void
    */
    public function printLayout()
    {
        print $this->getLayout();
    }

    /**
     * Get result all treasure position
     * 
     * @return array
    */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Check the game in not end
     * 
     * @return bool
    */
    public function failedGame()
    {
        return $this->map[$this->x][$this->y] === '#' ||
            $this->x < 0 ||
            $this->y < 0 ||
            $this->x > (count($this->map) - 1) ||
            $this->y > (count($this->map[0]) - 1);
    }

    /**
     * Navigate user base on input
     * 
     * @return void
    */
    public function navigate(string $input)
    {
        switch ($input) {
            case self::UP:
                $this->x--;
                break;
            case self::DOWN:
                $this->x++;
                break;
            case self::RIGHT:
                $this->y++;
                break;
            case self::LEFT:
                $this->y--;
                break;
            default:
                print "\nSalah input silahkan jalankan kembali program!\n";
                exit;
                break;
        }

        $this->checkAndSetTreasure();
    }

    /**
     * Generate random player position
     * 
     * @return void
    */
    protected function randomPlayerPosition()
    {
        $x = rand(0, count($this->map)-1);
        $y = rand(0, count($this->map[0])-1);

        while ($this->x !== $x && $this->y !== $y) {
            if ($this->map[$x][$y] === '.') {
                $this->x = $x;
                $this->y = $y;
            } else {
                $x = rand(0, count($this->map)-1);
                $y = rand(0, count($this->map[0])-1);
            }
        } 
    }
    
    /**
     * Generate random treasure
     * 
     * @return void
    */
    protected function randomTreasure()
    {
        $treasure = 0;
        $total = rand(1, 6); //random treasure
        while ($treasure < $total) { // random 5 treasure
            $x = rand(0, count($this->map)-1);
            $y = rand(0, count($this->map[0])-1);
            if ($this->map[$x][$y] !== '#') {
                if ($this->map[$x][$y] !== self::HIDDEN_TREASURE) {
                    $this->map[$x][$y] = self::HIDDEN_TREASURE;
                    $treasure++;
                }
            }
        }
    }

    /**
     * Check treasure and collect all position detect
     * 
     * @return void
    */
    protected function checkAndSetTreasure()
    {
        if ($this->map[$this->x][$this->y] === self::HIDDEN_TREASURE) {
            $this->result[] = [
                "x" => $this->x, 
                "y" => $this->y
            ];

            //mark position as found treasure
            $this->map[$this->x][$this->y] = '$';
        }
    }

    /**
     * Generate layout
     * 
     * @return string
    */
    protected function getLayout()
    {
        $layout = "";

        foreach ($this->map as $x => $row) {
            foreach ($row as $y => $cell) {
                $mark = $cell;

                if ($cell === self::HIDDEN_TREASURE) { // hide treasure
                    $mark = "."; 
                }

                if ($this->x === $x && $this->y === $y) { //show players position 
                    $mark = self::PLAYER;
                }

                $layout .= $mark;

                if ($y < count($row) - 1) {
                    $layout .= " ";
                }
            }

            $layout .= "\n";
        }

        return $layout;
    }
}