---
title: Quick Start
previous: installation
next: configuration
---

Lets see how to use the library.

When you install the library using composer, you will also find an `example` directory in the root of the project, which contains several examples of how to use the library. However, we are going to create a new example here.

Lets start by creating a new directory for our project.

```bash
mkdir my-project
cd my-project
```

After installing the library via composer or github (see [installation](/en/installation)), you can create a new file and start using the library.

```php
composer require dikki/claude-sdk
```

```bash
touch index.php # on linux/macOS
New-Item index.php # on windows
```

## Simple Application

We will start with the simplest possible example to demonstrate how the library works.

Open the file in your favorite editor and add the following code to it, which will be [explained below in detail](#code-explanation).

```php
<?php

require_once '/path/to/vendor/autoload.php';

// create a new claude instance using the claude builder
$claude = (new \Dikki\Claude\ClaudeBuilder())
    // use a DotEnv (e.g. dikki/dotenv) library instead of directly in the code
    // save your api key in a .env file and load it using the DotEnv library
    ->withApiKey("enter-your-api-key-here")
    ->build();

// create a new chat message using the message builder
$messages = (new \Dikki\Claude\Message\MessageBuilder())
    // you can remove this line if you want to start a new conversation
    ->assistant("You are a helpful assistant.")
    // actual prompt to send to claude
    ->user("Write a two liner sonnet on love.")
    ->build();

// send the message to claude
$response = $claude->send($messages);

// YOU CAN GET THE RESPONSE EITHER AS A TEXT RESPONSE ONLY
// OR, AS AN ARRAY CONTAINING THE RAW RESPONSE FROM CLAUDE

// TEXT RESPONSE ONLY
echo $response->getContent();

"""
Here is a two line sonnet about love:\n
\n
My heart beats fast when I see your face,\n
Our souls unite in a warm embrace.
"""

// RAW RESPONSE FROM CLAUDE
print_r($response->getRaw());

"""
^ array:8 [
  "id" => "msg_017Qn4Ao9pBiZ7D191HHwHwK"
  "type" => "message"
  "role" => "assistant"
  "model" => "claude-2.1"
  "content" => array:1 [
    0 => array:2 [
      "type" => "text"
      "text" => """
        Here is a two line sonnet about love:\n
        \n
        My heart beats fast when I see your face,\n
        Our souls unite in a warm embrace.
        """
    ]
  ]
  "stop_reason" => "end_turn"
  "stop_sequence" => null
  "usage" => array:2 [
    "input_tokens" => 43
    "output_tokens" => 35
  ]
]
"""
```

Please do not forget to add your own API key for the code to function.

{id="code-explanation"}

## Code Explanation

Now, lets explain the code.

### 1. **Creating Claude Instance**

```php
$claude = (new \Dikki\Claude\ClaudeBuilder())
    ->withApiKey("enter-your-api-key-here")
    ->build();
```

The `ClaudeBuilder` is used to create a new instance of the Claude client. The following steps are taken:

- **API Key Setup:** `withApiKey` is used to set the API key required to authenticate with Claude's API.
- **Build:** The `build()` method finalizes the configuration and returns a Claude instance ready to use.

> **WARNING:** Store sensitive information like API keys in a `.env` file and load them using a library such as [dikki/dotenv](https://packagist.org/packages/dikki/dotenv) or [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) to enhance security.

Did you notice that in the response recieved via `getRaw()` method, there is a `model` key? This is the model that was used to generate the response.

Notice that we did not specify the model in the `ClaudeBuilder`, so the default model `claude-2.1` was used.

You can specify the model in the `ClaudeBuilder` like this:

```php
$claude = (new \Dikki\Claude\ClaudeBuilder())
    ->withApiKey("enter-your-api-key-here")
    ->withModel(\Dikki\Claude\Enum\ModelEnum::CLAUDE_3_HAIKU)
    ->build();
```

The `ModelEnum` contains the following models:

```php
    case CLAUDE_3_OPUS = 'claude-3-opus-20240229';
    case CLAUDE_3_5_SONNET = 'claude-3-5-sonnet-20241022';
    case CLAUDE_3_SONNET = 'claude-3-sonnet-20240229';
    case CLAUDE_3_5_HAIKU = 'claude-3-5-haiku-20241022';
    case CLAUDE_3_HAIKU = 'claude-3-haiku-20240307';
    case CLAUDE_2_1 = 'claude-2.1';
```

You can also directly specify the model via string name if you don't want to use the `ModelEnum`, though it is recommended to use the `ModelEnum` for better type safety and autocompletion. You won't have to bother when Anthropic changes the model versions.

```php
$claude = (new \Dikki\Claude\ClaudeBuilder())
    ->withApiKey("enter-your-api-key-here")
    ->withModel("claude-3-5-sonnet-20241022")
    ->build();
```

Now there are more features to explore, but we will discuss them separately.

### 2. **Building Message**

```php
$messages = (new \Dikki\Claude\Message\MessageBuilder())
    ->assistant("You are a helpful assistant.")
    ->user("Write a two liner sonnet on love.")
    ->build();
```

The `MessageBuilder` helps you construct a chat message. Here's how it works:

- **Assistant Initialization:** Use `->assistant()` to provide context for the assistant, such as its personality or purpose.
- **User Prompt:** Use `->user()` to specify the actual prompt or question you want to send to Claude.
- **Build:** Finalizes the message construction, returning a format Claude can process.

### 3. **Sending the Message**

```php
$response = $claude->send($messages);
```

The `send` method sends the constructed message to Claude. It will return a response object that contains the results of the sent message.

### 4. **Handling the Response**

```php
// TEXT RESPONSE ONLY
echo $response->getContent();

// RAW RESPONSE FROM CLAUDE
print_r($response->getRaw());
```

You can handle the response in two ways as already shown in the code above:

- **Text Response Only:** `getContent()` returns the main content of the response as a simple text string. It is probably what you want.
- **Raw Response:** `getRaw()` provides the full API response as an array, including metadata, which can be useful for debugging or advanced use cases. You will receive model used, tokens used, etc.

## Next Steps

Now that you understand the basics, move on to the [configuration](/en/configuration) section to explore advanced settings and customization options for the Claude SDK.
