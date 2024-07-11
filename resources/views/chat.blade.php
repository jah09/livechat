<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Live chat</title>
    @vite(['resources/css/app.css' , 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="bg-gray-200 h-screen flex flex-col justify-center  items-center w-screen ">
        <h1 class="mt-10 text-xl font-medium">Welcome to live chat</h1>
        <div class=" p-4 flex mt-10 w-screen gap-x-2">
            <div class="p-4 w-1/2 bg-gray-400 rounded-md">
                <h5 class=" font-medium">Message receive</h5>
                <div id="messages-container">
                    @foreach ($messages as $message)
                    <p class="w-80 rounded-md h-12 bg-gray-300 mt-4" id="viewmessage">{{ $message->message }}</p>
                    @endforeach
                </div>
            </div>
            <div class="p-4 w-1/2  bg-gray-400 rounded-md">
                <div>
                    <h5 class=" font-medium">Send your message</h5>
                    <div class="mt-4">
                        <form action="/store" method="POST" id="formData">
                            @csrf
                            <input placeholder="Enter your message" class="w-80 rounded-md h-12 outline-none p-2 "
                                name="message" id="message" />
                            <button class="ml-6 h-12 w-32 bg-blue-500 p-2 rounded-md" type="submit">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function(){
                $('#formData').on('submit', function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '/store',
                        data: $(this).serialize(),
                        success: function(response){
                            $('#message').val(''); // it will clear the input field after submitting the form
                        },
                        error: function(error){
                            console.log(error);
                            alert('Message cant be send');
                        }
                    });
                });
                var channel = Echo.channel("livechat"); //access the livechat channel in pusher
                //it will listen the event
                channel.listen(".chatsent", function (data) {
                $('#messages-container').append('<p class="w-80 rounded-md h-12 bg-gray-300 mt-4">' + data.message + '</p>');
                });
            });           
                    
    </script>
</body>
</html>