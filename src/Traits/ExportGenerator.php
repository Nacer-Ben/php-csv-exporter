<?php


namespace Sujan\Exporter\Traits;


trait ExportGenerator
{
    /**
     * @param $data
     * @param $columns
     * @return array
     */
    protected function getLine($data, $columns)
    {
        $lines = [];
        foreach ($columns as $k => $key) {
            if (is_array($key)) {
                foreach ($key as $kk => $item) {
                    if (is_array($data)) {
                        $result = isset($data[$k][$item]) ? $data[$k][$item] : '';
                        array_push($lines, $result);
                    } else {
                        $result = $data->{$k}->{$item};
                        array_push($lines, $result);
                    }
                }
            } else {
                if($key == 'date') {
                    $value = is_array($data) ? $data[$key] : $data->{$key}->format('d-m-Y');
                } else {
                    $value = is_array($data) ? $data[$key] : $data->{$key};
                }
                array_push($lines, $value);
            }
        }

        return $lines;
    }

    /**
     * @param $data
     * @param $keys
     * @param $k
     * @return string
     */
    protected function getNestedData($data, $keys, $k)
    {
        foreach ($keys as $kk => $key) {
            if (is_array($data)) {
                $data = isset($data[$k][$key]) ? $data[$k][$key] : '';
            } else {
                $data = isset($data->{$k}->{$key}) ? $data->{$k}->{$key} : '';
            }

            if (is_array($data)) {
                $this->getNestedData($data, $key, $kk);
            }
        }

        return $data;
    }
}
