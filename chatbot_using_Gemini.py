import textwrap
import os
import google.generativeai as genai
from flask import Flask, request, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app) # Enable CORS for the app to allow cross-origin requests

from IPython.display import display
from IPython.display import Markdown

# Function to convert text to Markdown format (use this if you want to display the response in a Markdown format in Jupyter Notebook) 
def to_markdown(text):
  text = text.replace('•', '  *')
  return Markdown(textwrap.indent(text, '> ', predicate=lambda _: True))

GOOGLE_API_KEY = os.getenv('GOOGLE_API_KEY')    # Set your API key here

genai.configure(api_key='enter-your-api-key-here') # Sometimes the API key needs to be set explicitly

    
model = genai.GenerativeModel('gemini-1.5-flash') # Load the Gemini model

@app.route('/chat', methods=['POST']) # Create a route for the chat endpoint
def chat():
    data = request.json
    prompt = data.get('prompt')
    
    if not prompt:
        return jsonify({'error': 'No prompt provided'}), 400
    
    try:
        response = model.generate_content(f"give the gimini that how gemini should act as in the chatbot(Ex : act as a laptop repair center chatbot): {prompt}")
        generated_text = response.text  # Accessing the text attribute directly

        # Print the generated response to the console
        # print(f"Generated response: {generated_text}")

        return jsonify({'response': generated_text})
    except Exception as e:
        print(f"Error generating response: {e}")
        return jsonify({'error': 'Failed to generate response'}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)  # Run the app on all network interfaces on port 5000

    