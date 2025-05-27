class Ajax{
    static Post(form_button,after) {
        const form = form_button.parentElement.parentElement;
        const modal=form.parentElement.parentElement;
        const form_id = form.id;
        API.post(form.action,this.getFataForm(form_id));
        closeModal(modal.id);
        form.reset();
        after();
    }
    static getFataForm(form_id){
        return Array.from([...document.querySelectorAll(`#${form_id} input`), ...document.querySelectorAll(`#${form_id} select`), ...document.querySelectorAll(`#${form_id} textarea`)]).reduce((acc, field) => ({...acc,[field.name]: field.value}),{});
    }
}