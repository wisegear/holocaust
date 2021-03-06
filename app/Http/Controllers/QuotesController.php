<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotes;
use DB;

class QuotesController extends Controller
{

   public function __construct()
   {
		// Handle user authentication for each of the methods.
      $this->middleware('auth', ['except' => ['index', 'show']]);      
   }
   
   // Index page for the quotes section

    public function index()
    {
      // did the user use the search box?
      if (isset($_GET['search']))
      {
         $quotes = Quotes::where('published', true)
            ->where(function ($query) {
               $query->where('author', 'LIKE', '%' . $_GET['search'] . '%')
                  ->orWhere('quote', 'LIKE', '%' . $_GET['search'] . '%');
                  
        })
        ->paginate(12);
      
      } 
      // did the user click on an author?
      elseif (isset($_GET['author']))
      {
         $quotes = Quotes::where(function ($query) {
            $query->where('author_slug', 'LIKE', '%' . $_GET['author'] . '%')
                  ->where('published', true);
         })
         
         ->paginate(12);
      } 
      
      else {
         // Return all quotes
         $quotes = Quotes::where('published', true)->paginate(12);
      }

        $unique = Quotes::distinct()->limit(10)->pluck('author'); 
        $unpublished = Quotes::where('published', false)->get();
           
        //  Return quotes index page
        return view ('quotes.index', compact('quotes', 'unique', 'unpublished'));
    }

	//*******************************************************
  	//  View the timeline index
  	//******************************************************* 
    public function create()
    {
      $this->authorize('Admin');

      //  Return the form to create a new event
      return view('quotes.create');
        
    }

	//*******************************************************
  	//  Store an event
  	//******************************************************* 
   
   public function store(Request $request)
   {
      $this->authorize('Admin');

      // Open the DB ready for new event
      $new_quote = new Quotes;
      
      // Associate the form results to the DB fields
      $new_quote->author = $request->quote_author;
      $new_quote->quote = $request->quote_text;
      if ($request->published === 'on') {
            
         $new_quote->published = 1; } else {
            $new_quote->published = 0;
     }

      // Save the new event to the DB
      $new_quote->save();
      
      // Redirect back to the timeline index
      return redirect()->action([QuotesController::class, 'index']);
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

	//*******************************************************
  	//  Edit an event
  	//******************************************************* 
   
   public function edit($id)
   {
      $this->authorize('Admin');

      // Get required data elements
      $quote = Quotes::find($id);
      
      //  Return the form to edit an event
      return view('quotes.edit')->with('quote', $quote);
   }

	//*******************************************************
  	//  Update an event
  	//*******************************************************
   
   public function update(Request $request, $id)
   {
      $this->authorize('Admin');

      // Get required data elements
      $edit_quote = Quotes::find($id);
      
      // Update the existing record
      $edit_quote->author = $request->quote_author;
      $edit_quote->quote = $request->quote_text;
        // Check if the quote is to be published

        if ($request->published === 'on') {
            
         $edit_quote->published = 1; } else {
            $edit_quote->published = 0;
     }
      
      // Save the changes
      $edit_quote->save();
      
      //return the viewer to timeline index
      return redirect()->action([QuotesController::class, 'index']);
   }

	//*******************************************************
  	//  Destroy an event
  	//*******************************************************  
   
   public function destroy($id)
   {
      $this->authorize('Admin');
      
      // Destroy the timeline event
      Quotes::destroy($id);
      
      // Return viewer to the events page
      return redirect()->back();
   }
}
