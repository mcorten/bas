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
      const keyInput = $(readMessageForm).find('[name="key"]');

      readMessageForm.addEventListener('submit', (e) => {
        e.preventDefault();

        this.#clearResultForm();
        $.get(`/message/read/${recipientInput.val()}/${keyInput.val()}`)
          .done((response) => {
            if (response.found === true) {
              this.#displayMessage(response.text);
              return;
            }

            this.#setResultError("Message not found!");
          })
          .fail((response) => {
            this.#setResultError(response.responseJSON.error);
          })

      })

    }

    #clearResultForm() {
      $('#error').html('');

      const textArea = $('textarea');
      textArea.css('display', 'none');
      textArea.text('');
    }

    #setResultError(text) {
      $('#error').html(text);
    }

    #displayMessage(message) {
      const textArea = $('textarea');
      textArea.text(message);
      textArea.css('display', 'inherit');
    }
}
