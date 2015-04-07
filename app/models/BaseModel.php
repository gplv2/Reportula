<?php

namespace app\models;

use Eloquent;
use DB;

class BaseModel extends Eloquent {

public function getAllColumnsNames()
    {
        switch (DB::connection()->getConfig('driver')) {
            case 'pgsql':
		$property = DB::table('information_schema.columns')
			->select('column_name')
			->where("table_name", "=", "?")
                        ->setBindings([$this->table])
                        ->get();
                $reverse = true;
                $column_name = "column_name";
                break;

            case 'mysql':
		$property = DB::table('information_schema.COLUMNS')
			->select('COLUMN_NAME')
			->where("TABLE_SCHEMA", "=", "?")
			->and("TABLE_NAME", "=", "?")
                        ->setBindings([DB::connection()->getConfig('database'), $this->table])
                        ->get();
                $reverse = false;
                $column_name = "COLUMN_NAME";
                break;

            case 'sqlsrv':
                $parts = explode('.', $this->table);
                $num = (count($parts) - 1);
                $table = $parts[$num];

		$property = DB::table("?.INFORMATION_SCHEMA.COLUMNS")
			->select('column_name')
			->and("TABLE_NAME", "=", "?")
                        ->setBindings([DB::connection()->getConfig('database'), $this->table])
                        ->get();

                $column_name = 'column_name';
                $reverse = false;
                break;

            default:
                $error = 'Database driver not supported: '.DB::connection()->getConfig('driver');
                throw new Exception($error);
                break;
        }

        $columns = array();

        foreach ($property as $column)
        {
            $columns[] = $column->$column_name;
        }

        if ($reverse)
        {
            $columns = array_reverse($columns);
        }

        return $columns;
    }
}
