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

      const readMessageForm = formCollection[0];

      readMessageForm.addEventListener('submit', (e) => {
        e.preventDefault();

        $.post('/read', {}, () => {
          alert("Successfully read!");
        });

      })

    }

}
