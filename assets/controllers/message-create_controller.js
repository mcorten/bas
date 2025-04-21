import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
      $( document ).ready(() => {
        this.#initializeForm();
      });
    }

    #initializeForm() {
      const formCollection = $('form');
      if (formCollection.length > 1) {
        alert("Error: multiple forms found");
      }

      const readMessageForm = formCollection[0]

      const recipientInput = $(readMessageForm).find('[name="recipient"]');
      const textInput = $(readMessageForm).find('[name="text"]');

      readMessageForm.addEventListener('submit', (e) => {
        e.preventDefault();

        this.#clearForm();
        $.post('/message', {
          recipient: recipientInput.val(),
          text: textInput.val()
        })
          .done((response) => {
            this.#setSuccess('Success: send this to the recipient: <br >'
              + 'user name: ' + recipientInput.val() + '<br />'
              + 'secret key: '+ response.key);
          })
          .fail((response) => {
            this.#setError(response.responseJSON.error);
          })

      })

    }

    #clearForm() {
      $('#success').html('');
      $('#error').html('');
    }

  #setError(text) {
    $('#error').html(text);
  }

  #setSuccess(text) {
    $('#success').html(text);
  }

}
