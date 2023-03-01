<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Table;

/**
 * The class manages the operations on the table entities
 * 
 * @author Marino Giudice
 */

class TableController extends Controller
{
    /**
     * Displays tables index page.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {   
        //gets the tables from the db
        $tables=Table::all();
        //paginates the results
        $paginatedTables=Table::paginate(10);
        //returns the view
        return view('admin.tables.index',['paginatedTables'=> $paginatedTables, 'tables' => $tables]);
    }

    /**
     * Shows the the view for creating a new table.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('admin.tables.addtable');
    }

    /**
     * Store a new table in the db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {
        //validates the input
        $request->validate([
            'table_number' =>'bail|required|bail|numeric|bail|unique:tables',
        ]);
        //creates the new table object
        $table =new Table;
        $table->table_number=$request->input('table_number');
        //writes the new object in the db
        if(!$table->save()) {
            return redirect('/admin/tables')->with('fail', 'Impossible to add New Table Db Error');
        }
        return redirect('/admin/tables')->with('success', 'New Table added Successfully');
    }

    /**
     * Displays the view to edit a table.
     *
     * @param  Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('admin.tables.edit',['table' => $table]);
    }

    /**
     * Update the table in the db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        //validates the input form
        $request->validate([
            'table_number' =>'bail|required|bail|numeric',
            Rule::unique('tables')->ignore($table->table_number),
        ]);
        //gets the current table from the db
        $tableMod = Table::where('table_number',$table->table_number)->first();
        //updates the table object
        $tableMod->table_number = $request->input('table_number');
        //writes in the db
        if(!$tableMod->save()) {
            return redirect('/admin/tables')->with('fail', 'Impossible to update Table Db Error');
        }
        return redirect('/admin/tables')->with('success', 'Table updated Successfully');
    }

    /**
     * Deletes the specified table from the db.
     *
     * @param  Table  $table
     * @return \Illuminate\Http\Response
     */

    public function destroy(Table $table)
    {
        if(!$table->delete()) {
            return redirect('/admin/tables')->with('fail', 'Impossible to Delete Table Internal Error');
        }
        return redirect('/admin/tables')->with('success', 'Table Deleted');

    }

    //return the results of the table filter
    public function filterTables(Request $request) {
        $request->validate(['table' => 'required'
    ]);
    $tables=Table::all();
    $results=Table::where('table_number',$request->table)->paginate(10);
    return view('admin.tables.index',['paginatedTables'=> $results, 'tables' => $tables]);
    }
}
