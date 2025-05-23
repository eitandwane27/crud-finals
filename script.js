// === DOM ELEMENTS === //
document.addEventListener("DOMContentLoaded", () => {
    const chatMessages = document.getElementById("chat-messages"); // Where messages will appear
    const userInput = document.getElementById("user-input"); // The input field where user types
    const sendButton = document.getElementById("send-button"); // Button to send a message

    //for basic user questions
    const cleanedPrompt = userInput.value
        .toLowerCase()
        .replace(/[?.,!]/g, "")
        .trim();

    const constantResponse = {
        "what is this website":
            "This is a hospital management system built to help patients and staff.",
        "what are your operating hours": "Our hospital is open 24/7.",
        "how can i inquire":
            "You can book an appointment by navigating to the 'Contact' section.",
        "pogi ba si sir": "YES NA YES!!!",
        what: "hafen vela? why u crying agen? I know vamfyr right?",
    };
    //animation
    let typingMessageElement = null;

    function showTypingAnimation(isApi = false) {
        typingMessageElement = document.createElement("div");
        typingMessageElement.classList.add(
            "message",
            "bot-message",
            "typing-message"
        );

        const profileImage = document.createElement("img");
        profileImage.classList.add("profile-image");
        profileImage.src = "128561149_GIU AMA 255-08.svg";
        profileImage.alt = "Bot";

        const messageContent = document.createElement("div");
        messageContent.classList.add("message-content", "typing-content");

        if (isApi) {
            // API thinking animation
            const thinkingText = document.createElement("div");
            thinkingText.classList.add("thinking-text");
            thinkingText.textContent = "AI is thinking";
            messageContent.appendChild(thinkingText);
        }

        // Create typing dots container
        const dotsContainer = document.createElement("div");
        dotsContainer.classList.add("typing-dots");

        // Create three dots
        for (let i = 0; i < 3; i++) {
            const dot = document.createElement("span");
            dot.classList.add("typing-dot");
            dotsContainer.appendChild(dot);
        }

        messageContent.appendChild(dotsContainer);
        typingMessageElement.appendChild(profileImage);
        typingMessageElement.appendChild(messageContent);

        chatMessages.appendChild(typingMessageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTypingAnimation() {
        if (typingMessageElement) {
            typingMessageElement.remove();
            typingMessageElement = null;
        }
    }

    // Add this new function for typing animation
    async function typeMessage(message, isApiResponse = false) {
        const messageElement = document.createElement("div");
        messageElement.classList.add("message", "bot-message");

        const profileImage = document.createElement("img");
        profileImage.classList.add("profile-image");
        profileImage.src = "128561149_GIU AMA 255-08.svg";
        profileImage.alt = "Bot";

        const messageContent = document.createElement("div");
        messageContent.classList.add("message-content", "typing-text");
        messageContent.textContent = "";

        messageElement.appendChild(profileImage);
        messageElement.appendChild(messageContent);
        chatMessages.appendChild(messageElement);

        // Type the message character by character
        const typingSpeed = isApiResponse ? 30 : 50; // Faster for API responses
        for (let i = 0; i < message.length; i++) {
            messageContent.textContent += message[i];
            chatMessages.scrollTop = chatMessages.scrollHeight;
            await new Promise((resolve) => setTimeout(resolve, typingSpeed));
        }

        // Wait for 2 seconds after typing is complete
        await new Promise((resolve) => setTimeout(resolve, 2000));

        // Add the final class to show the complete message
        messageContent.classList.add("message-complete");
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    if (constantResponse[cleanedPrompt]) {
        addMessage(constantResponse[cleanedPrompt], false);
    }

    // === CONFIGURATION === //
    const API_KEY = "AIzaSyCrDCA1le2EY2tSMUu-JTXEusSnXFaXv6k";
    const API_URL =
        "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent"; // Gemini API endpoint

    // === FUNCTIONS === //

    // Sends the user's prompt to Gemini API and gets a response
    async function generateResponse(prompt) {
        const systemPrompt = `Respond briefly and directly. You are a warm, knowledgeable health and wellness assistant. Keep answers short, no more than 50 words.\n\nUser: ${prompt}`;

        const response = await fetch(`${API_URL}?key=${API_KEY}`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                contents: [
                    {
                        parts: [{ text: systemPrompt }],
                    },
                ],
            }),
        });

        // If something went wrong, show an error
        if (!response.ok) {
            throw new Error("Failed to generate response");
        }

        const data = await response.json(); // Convert API response to usable object
        return data.candidates[0].content.parts[0].text; // Get the actual reply text
    }

    // Cleans Markdown-style formatting (like **bold**, # headers, etc.)
    function cleanMarkdown(text) {
        return text
            .replace(/#{1,6}\s?/g, "") // Remove headers
            .replace(/\*\*/g, "") // Remove bold asterisks
            .replace(/\n{3,}/g, "\n\n") // Limit extra newlines
            .trim(); // Remove spaces at the beginning and end
    }

    // Adds a message to the chat window
    function addMessage(message, isUser) {
        const messageElement = document.createElement("div");
        messageElement.classList.add("message");
        messageElement.classList.add(isUser ? "user-message" : "bot-message");

        const profileImage = document.createElement("img");
        profileImage.classList.add("profile-image");
        profileImage.src = isUser ? "user.jpg" : "bot.jpg";
        profileImage.alt = isUser ? "User" : "Bot";

        const messageContent = document.createElement("div");
        messageContent.classList.add("message-content");
        messageContent.textContent = message;

        messageElement.appendChild(profileImage);
        messageElement.appendChild(messageContent);

        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Ensure chat is expanded when new message arrives
        const chatContainer = document.querySelector(".chat-container");
        if (!chatContainer.classList.contains("expanded")) {
            chatContainer.classList.add("expanded");
        }
    }

    // Handles sending a user message and showing the bot reply
    async function handleUserInput() {
        const userMessage = userInput.value.trim();

        if (!userMessage) return;

        addMessage(userMessage, true);
        userInput.value = "";

        sendButton.disabled = true;
        userInput.disabled = true;

        const cleanedPrompt = userMessage
            .toLowerCase()
            .replace(/[?.,!]/g, "")
            .trim();

        if (constantResponse[cleanedPrompt]) {
            showTypingAnimation(false);
            if (cleanedPrompt === "pogi ba si sir") {
                const audio = new Audio(
                    "music/Macho Guapito - Rico J. Puno (Official Lyric Video)-[AudioTrimmer.com] (3).mp3"
                );
                audio.play();
            }

            await new Promise((resolve) => setTimeout(resolve, 3000)); // Show typing animation for 1 second
            removeTypingAnimation();
            await typeMessage(constantResponse[cleanedPrompt], false);

            sendButton.disabled = false;
            userInput.disabled = false;
            userInput.focus();
            return;
        }

        showTypingAnimation(true); // Show API thinking animation

        try {
            const botReply = await generateResponse(userMessage);
            //await new Promise((resolve) => setTimeout(resolve, 4000));
            removeTypingAnimation();
            await typeMessage(cleanMarkdown(botReply), true);
        } catch (error) {
            console.error("Error:", error);
            removeTypingAnimation();
            await typeMessage(
                "Sorry, I encountered an error. Please try again.",
                false
            );
        } finally {
            sendButton.disabled = false;
            userInput.disabled = false;
            userInput.focus();
        }
    }

    // === EVENT LISTENERS === //

    // Handle click on Send button
    sendButton.addEventListener("click", handleUserInput);

    // Handle Enter key press (but not Shift+Enter for newlines)
    userInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault(); // Don't add a new line
            handleUserInput(); // Send the message
        }
    });

    const chatContainer = document.querySelector(".chat-container");
    const chatHeader = document.querySelector(".chat-header");
    let isExpanded = false;

    // Toggle chat container
    chatHeader.addEventListener("click", (e) => {
        e.stopPropagation();
        isExpanded = !isExpanded;
        chatContainer.classList.toggle("expanded");
    });

    // Close chat when clicking outside
    document.addEventListener("click", (e) => {
        if (!chatContainer.contains(e.target) && isExpanded) {
            isExpanded = false;
            chatContainer.classList.remove("expanded");
        }
    });

    // Prevent chat from closing when clicking inside
    chatContainer.addEventListener("click", (e) => {
        e.stopPropagation();
    });
});
