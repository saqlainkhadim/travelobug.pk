<h3>Contact us</h3>
<form action="{{ url('contact/form') }}" method="post">
    @csrf
    <div class="my-3">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name">
    </div>
    <div class="my-3">
        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email">
    </div>
    <div class="my-3">
        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Write the subject">
    </div>
    <div class="my-3">
        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="6" placeholder="Write your message"></textarea>
    </div>
    <div class="my-3">
        <button class="btn btn-violet btn-lg">Submit</button>
    </div>
</form>
@if ($errors->any())
    <p class="text-danger">Please, fill all the fields.</p>
@endif
@if(session('success'))
    <p class="text-success">{{ session('success') }}</p>
@endif
