<x-layout>

	<div class="">
		<div class="">
			<div class="mb-10">
				<h1 class="text-xl font-bold text-center">Edit Quote</h1>
				<p class="text-sm text-gray-500 text-center">Enter a new quote below, use the text editor to format the text exactly as you would want others to see it.</p>
			</div>
			
			<div class="mx-auto w-1/2"> 
				<form action="/quotes/{{$quote->id}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<div class="flex flex-col space-y-5">			
					<div class="">
						<label for="author" class="block">Quote Author</label>
						<input type="text" id="quote-author" name="quote_author" class="h-8 w-full block" value="{{ $quote->author }}">
					</div>
					
					<div class="">
						<label for="quote_text block">Quote Text</label>
						<textarea name="quote_text" id="quote_text" class="block w-full">{{ $quote->quote }}</textarea>
					</div>	
					
					<div class="">
						<label for="Published" class="">Publish it?</label>
						<input type="checkbox" id="published" name="published"
						@if ($quote->published == 1)
							checked="checked"
						@endif
						>								
					</div>
					
					<div class="">
						<button type="submit" class="border rounded-md py-1 px-2 bg-green-300">Submit</button>
					</div>	
					
				</div>
				
					
				</form>

			</div> <!-- end col-md-12 -->
				
		</div>
	</div>
				
	</x-layout>