import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["menu"]
    static classes = ["hidden"]
    
    connect() {
        // Fermer le dropdown si on clique ailleurs
        this.boundCloseOnClickOutside = this.closeOnClickOutside.bind(this);
        document.addEventListener('click', this.boundCloseOnClickOutside);
    }
    
    disconnect() {
        document.removeEventListener('click', this.boundCloseOnClickOutside);
    }
    
    toggle() {
        this.menuTarget.classList.toggle('hidden');
    }
    
    close() {
        this.menuTarget.classList.add('hidden');
    }
    
    closeOnClickOutside(event) {
        if (!this.element.contains(event.target)) {
            this.close();
        }
    }
}