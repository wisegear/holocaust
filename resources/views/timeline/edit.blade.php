<x-layout>

	<div>
		<div class="">
			<div class="mb-10">
				<h1 class="text-xl text-center font-bold">Edit Timeline Event</h1>
				<p class="text-center text-gray-500 text-sm">Enter a new event below, use the text editor to format the text exactly as you would want others to 
				see it.</p>
			</div>
			
			<div class="w-1/2 mx-auto"> 

				<form method="POST" action="/timeline/{{ $timeline_event->id }}">
				{{ csrf_field() }}
				{{ method_field('PUT')}}

				<div class="space-y-6">
				
					<div class="">
						<label for="title" class="block">Event Title</label>
						<input type="text" id="title" name="title" class="w-full" value="{{$timeline_event->title}}">
					</div>
					
					<div class="">
						<label for="event_date" class="block">Event Date</label>
						<input type="date" id="event_date" name="event_date" class="" value="{{$timeline_event->event_date->format('Y-m-d')}}">
					</div>	
					
					<div class="">
						<label for="description" class="block">Description</label>
						<textarea id="description" name="description" class="w-full">{{$timeline_event->description}}</textarea>
					</div>	
					
					<div class="">
						<label for="Published" class="">Published?</label>
						<input type="checkbox" id="published" name="published" checked="checked">						
					</div>
					
					<div class="">
						<button type="submit" class="border rounded-md text-sm py-1 px-2 bg-green-300">Submit</button>
					</div>	
					
				</div>
				
					
				</form>

			</div> <!-- end col-md-12 -->			
			
		</div>
	</div>
				
</x-layout>