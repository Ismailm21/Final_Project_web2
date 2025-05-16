
    <title>Messenger</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .chat-container {
            height: calc(100vh - 80px);
        }

        .user-panel {
            background-color: #ffffff;
            height: 100%;
            overflow-y: auto;
            border-right: 1px solid #dee2e6;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.03);
        }

        .user-item {
            padding: 15px;
            cursor: pointer;
            transition: background 0.2s ease;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
        }

        .user-item img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .user-item:hover {
            background-color: #f8f9fa;
        }

        .user-item.active {
            background-color: #007bff;
            color: #fff;
        }

        .chat-box {
            display: flex;
            flex-direction: column;
            height: 100%;
            background-color: #fff;
            border-left: 1px solid #dee2e6;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.01);
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            background-color: #f1f3f5;
            font-weight: bold;
            font-size: 18px;
        }

        .chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .chat-footer {
            padding: 15px;
            border-top: 1px solid #dee2e6;
            background-color: #fff;
            display: flex;
            gap: 10px;
        }

        .msg-bubble {
            padding: 12px 18px;
            border-radius: 20px;
            max-width: 75%;
            word-break: break-word;
            font-size: 14px;
            line-height: 1.5;
        }

        .send_messages {
            justify-content: flex-end;
            display: flex;
            margin-bottom: 12px;
        }

        .send_messages .msg-bubble {
            background-color: #dfe4ea;
        }

        .received_messages {
            justify-content: flex-start;
            display: flex;
            margin-bottom: 12px;
        }

        .received_messages .msg-bubble {
            background-color: #007bff;
            color: white;
        }

        .img-message {
            max-width: 250px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .chat-container {
                flex-direction: column;
            }

            .user-panel {
                border-right: none;
                border-bottom: 1px solid #dee2e6;
            }

            .chat-box {
                border-left: none;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="row chat-container">
            <!-- Left User Panel -->
            <div class="col-md-3 user-panel p-0">
                @forelse ($users as $user)
                    <div class="user-item" id="{{ $user->id }}" onclick="selectUser({{ $user->id }})">
                        {{--                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="avatar">--}}
                        <div>{{ $user->name }}</div>
                    </div>
                @empty
                    <p class="p-3">No users found.</p>
                @endforelse
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">


            <!-- Right Chat Panel -->
            <div class="col-md-9 p-0 chat-box">
                <div class="chat-header">Messenger</div>
                <div class="chat-body" id="chat-body"></div>
                <div class="chat-footer">
                    <input type="text" id="messageInput" class="form-control" placeholder="Type your message..." />
                    <button class="btn btn-success" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        let authUserId = "{{ Auth::user()->id }}";
        let userID = null;
        let newMessages = null;

        $('#messageInput').on('keypress', function (e) {
            if (e.which === 13) sendMessage();
        });

        function selectUser(userId) {
            $('.user-item').removeClass('active');
            $('#' + userId).addClass('active');
            $('#chat-body').empty();
            userID = userId;
            getChatHistory();
            setupEventSource();
        }

        function getChatHistory() {
            $('#chat-body').empty();
            $.ajax({
                type: 'get',
                url: '{{ URL('communication-history') }}',
                data: { userID: userID },
                success: function (data) {
                    data.forEach(addMessageToBoard);
                }
            });
        }

        function sendMessage() {
            const msg = $("#messageInput").val();
            if (!msg || !userID) return;

            console.log('Sending:', msg, 'to', userID); // 👈 add this

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route('send-message') }}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'message': msg,
                    'user': userID,
                },
                success: function (data) {
                    console.log('Response:', data); // 👈 also log this
                    addMessageToBoard(data);
                    $("#messageInput").val('');
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }


        function setupEventSource() {
            if (newMessages) newMessages.close();
            newMessages = new EventSource(`/get-new-messages/${userID}`);


            newMessages.onmessage = function (event) {
                let message = JSON.parse(event.data).item;
                addMessageToBoard(message);
            };
        }

        function addMessageToBoard(message) {
            const isSender = message.sender_id === parseInt(authUserId);


            const wrapper = isSender ? 'send_messages' : 'received_messages';
            const bubble = `
            <div class="${wrapper}">
                <div class="msg-bubble">
                    ${checkMessageType(message)}
                </div>
            </div>`;
            $('#chat-body').append(bubble);
            $('#chat-body').scrollTop($('#chat-body')[0].scrollHeight);
        }

        function checkMessageType(message) {
            if (message.message_type === 'attachment') {
                return `<img src="{{ URL::asset('/') }}${message.message}" class="img-message">`;

                    }
                    return message.message;
                    }
    </script>

