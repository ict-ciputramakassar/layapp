@extends('views_backend.layouts.app')

@section('title', 'Add Team Member - LayApp')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
      <div class="">
        <h1 class="fs-3 mb-1">Add Member</h1>
        <p class="mb-0">Manage your team members</p>
      </div>
      <div>
        <a href="{{ route('admin.inventory') }}" class="btn btn-primary">Go to Member List</a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-4">
        <form id="addProductForm">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="full_name" class="form-label">Member Name</label>
              <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter member name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="dob" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="phone_number" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="08xxxxxxxxxxx" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">Member Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="height" class="form-label">Member Height</label>
              <input type="number" class="form-control" id="height" name="height" placeholder="180" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="weight" class="form-label">Member Weight</label>
              <input type="number" class="form-control" id="weight" name="weight" placeholder="80" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="license" class="form-label">License</label>
              <input type="text" class="form-control" id="license" name="license" placeholder="A" required maxlength="1">
            </div>
            <div class="col-md-3 mb-3">
              <label for="valid_date" class="form-label">License Valid Date</label>
              <input type="date" class="form-control" id="valid_date" name="valid_date" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="member_type_id" class="form-label">Member Type</label>
              <select class="form-control" id="member_type_id" name="member_type_id" required>
                <option disabled selected hidden>Select Type</option>
                <option value="d61679fc-31c4-11f1-8cba-a036bc3bed8f">Athlete Non Profesional</option>
                <option value="dffb040e-31c4-11f1-8cba-a036bc3bed8f">Athlete Profesional</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="position_id" class="form-label">Member Position</label>
              <select class="form-control" id="position_id" name="position_id" required>
                <option disabled selected hidden>Select Position</option>
                <option value="d61679fc-31c4-11f1-8cba-a036bc3bed8f">Back</option>
                <option value="dffb040e-31c4-11f1-8cba-a036bc3bed8f">Center</option>
                <option value="dffb040e-31c4-11f1-8cba-a036bc3bed8f">Point Guard</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="position_id" class="form-label">Member Position</label>
              <select class="form-control" id="position_id" name="position_id" required>
                <option disabled selected hidden>Select Position</option>
                <option value="d61679fc-31c4-11f1-8cba-a036bc3bed8f">Back</option>
                <option value="dffb040e-31c4-11f1-8cba-a036bc3bed8f">Center</option>
                <option value="dffb040e-31c4-11f1-8cba-a036bc3bed8f">Point Guard</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="valid_date" class="form-label">License Valid Date</label>
              <input type="date" class="form-control" id="valid_date" name="valid_date" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="productCategory" class="form-label">Category</label>
            <select class="form-select" id="productCategory" required>
              <option value="">Select category</option>
              <option value="electronics">Electronics</option>
              <option value="clothing">Clothing</option>
              <option value="food">Food</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="productImage" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="productImage" accept="image/*" required>
          </div>
          <div class="mb-3">
            <label for="productDescription" class="form-label">Description</label>
            <textarea class="form-control" id="productDescription" rows="4"
              placeholder="Enter product description"></textarea>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Add Product</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <footer class="text-center py-2 mt-6 text-secondary ">
      <p class="mb-0">Copyright © 2026 InApp Inventory Dashboard. Developed by <a href="https://codescandy.com/" target="_blank" class="text-primary">CodesCandy</a> • Distributed by <a href="https://themewagon.com/" target="_blank" class="text-primary">ThemeWagon</a> </p>
    </footer>
  </div>
</div>
@endsection
