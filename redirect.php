<?php

class Redirect
{
    public $to;

    public function __toString()
    {
        $this->__destruct();
    }

    public function redirect($to)
    {
        $this->to = $to;
        return $this;
    }

    public function with($key, $value)
    {
        $_SESSION['flashmessages'][$key] = $value;
        return $this;
    }

    public function __destruct()
    {
        echo "
            <script>
                window.location.href = '$this->to';
            </script>
        ";

        return $this;
    }
}
