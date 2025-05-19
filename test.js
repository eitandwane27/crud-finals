const form = document.getElementById("chat-form");
const input = document.getElementById("chat-input");
const messages = document.getElementById("chat-messages");

const apiKey = "sk-abcdijkl1234uvwxabcdijkl1234uvwxabcdijkl";

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const message = input.value.trim();
    input.value = "";

    if (!message) return;

    messages.innerHTML += `
    <div class="message user-message">
      <span>${message}</span>
    </div>`;

    // Show loading or typing indicator
    messages.innerHTML += `
    <div class="message bot-message" id="typing">
      <span>Typing...</span>
    </div>`;

    // Delay request by 2 seconds
    setTimeout(async () => {
        try {
            const response = await axios.post(
                "https://api.openai.com/v1/chat/completions",
                {
                    model: "gpt-3.5-turbo",
                    messages: [{ role: "user", content: message }],
                    temperature: 0.7,
                    max_tokens: 1000,
                },
                {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${apiKey}`,
                    },
                }
            );

            const chatbotResponse = response.data.choices[0].message.content;

            document.getElementById("typing").remove(); // Remove typing message
            messages.innerHTML += `
        <div class="message bot-message">
          <span>${chatbotResponse}</span>
        </div>`;
        } catch (err) {
            console.error("API Error:", err);
            document.getElementById("typing").remove();
            messages.innerHTML += `
        <div class="message bot-message error">
          <span>⚠️ Error: ${
              err.response?.status === 429
                  ? "Rate limit exceeded. Try again later."
                  : "Something went wrong."
          }</span>
        </div>`;
        }
    }, 2000); // Delay in milliseconds
});
