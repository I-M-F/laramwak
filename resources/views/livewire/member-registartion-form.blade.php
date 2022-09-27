<div>

<form method="post" wire:submit.prevent="member_register" enctype="multipart/form-data">

        @if ($currentStep == 1)
        <div class="step-one">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    STEP 1/3 - Personal Details
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">First Name</label>
                                <input type="text" class="form-control" placeholder="Enter First Name" wire:model="first_name">
                                <span class="text-danger">@error('first_name') {{ $message }}@enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Middle Name</label>
                                <input type="text" class="form-control" placeholder="Enter Middle Name" wire:model="second_name">
                                <span class="text-danger">@error('second_name') {{ $message }}@enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Last Name</label>
                                <input type="text" class="form-control" placeholder="Enter Last Name" wire:model="maiden_name">
                                <span class="text-danger">@error('maiden_name') {{ $message }}@enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">ID Number</label>
                                <input type="text" class="form-control" placeholder="Enter Your ID No." wire:model="id_number">
                                <span class="text-danger">@error('id_number') {{ $message }}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email Address</label>
                                <input type="email" class="form-control" placeholder="Enter Email Address" wire:model="email">
                                <span class="text-danger">@error('email') {{ $message }}@enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Enter Phone Number" wire:model="phone">
                                <span class="text-danger">@error('phone') {{ $message }}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">County Of Residence</label>
                                <select class="form-control" wire:model="selectedClass">
                                    <option value="" selected>Select County Of Residence</option>
                                    @foreach ($county as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('selectedClass') {{ $message }}@enderror</span>
                            </div>
                        </div>

                        @if (!is_null($sections))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Sub-County Of Residence</label>
                                <select class="form-control" wire:model="selectedSection">
                                    <option value="" selected>Select SubCounty Of Residence</option>
                                    @foreach ($sections as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('selectedSection') {{ $message }}@enderror</span>
                            </div>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        @endif

        @if ($currentStep == 2)
        <div class="step-two">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    STEP 2/3 Spouse Details
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">First Name</label>
                                <input type="text" class="form-control" placeholder="Enter Spouse First Name" wire:model="spouse_name">
                                <span class="text-danger">@error('spouse_name') {{ $message }}@enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Last Name</label>
                                <input type="text" class="form-control" placeholder="Enter Spouse Last Name" wire:model="spouse_maiden_name">
                                <span class="text-danger">@error('spouse_maiden_name') {{ $message }}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="spouseStatus">Spouse Status</label>
                                <select class="form-control" wire:model="spouseStatus">
                                    <option value="" selected>Select Spouse Status</option>
                                    <option value="In Service">In Service</option>
                                    <option value="Veretan">Veretan </option>
                                    <option value="Widow">Widow</option>

                                </select>
                                <span class="text-danger">@error('spouseStatus') {{ $message }}@enderror</span> 
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Service No.</label>
                                <input type="text" class="form-control" placeholder="Enter Spouse Service No." wire:model="service_number">
                                <span class="text-danger">@error('service_number') {{ $message }}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Service Class</label>
                                <select class="form-control" wire:model="class">
                                    <option value="" selected>Select Service Class | Rank</option>
                                    <option value="General">General </option>
                                    <option value="Lieutenant general">Lieutenant general</option>
                                    <option value="Major general">Major general </option>
                                    <option value="Brigadier">Brigadier </option>
                                    <option value="Colonel">Colonel </option>
                                    <option value="Lieutenant colonel">Lieutenant colonel</option>
                                    <option value="Major">Major</option>
                                    <option value="Captain">Captain</option>
                                    <option value="Lieutenant">Lieutenant</option>
                                    <option value="Second lieutenant">Second lieutenant</option>
                                    <option value="Warrant Officer Class 1">Warrant Officer Class 1</option>
                                    <option value="Warrant Officer Class 2">Warrant Officer Class 2</option>
                                    <option value="Senior Sergeant">Senior Sergeant </option>
                                    <option value="Sergeant">Sergeant</option>
                                    <option value="Corporal">Corporal</option>
                                    <option value="Lance Corporal">Lance Corporal</option>
                                </select>
                                <span class="text-danger">@error('class') {{ $message }}@enderror</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if ($currentStep == 3)
        <div class="step-three">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    STEP 3/3 - Attachments
                </div>
                <div class="card-body">
                You will be able to edit and add a copy of your ID and Passport photo as soon as you are approved and logged in, make payment and Approved.
                    <!-- <div class="form-group">
                        <label for="">ID card</label>
                        <input type="file" class="form-control" wire:model="id_cardx">
                        <span class="text-danger">@error('$id_cardx') {{ $message }}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="passport_photo">Passport Photo</label>
                        <input type="file" class="form-control" wire:model="passport_photox">
                        <span class="text-danger">@error('passport_photox') {{ $message }}@enderror</span>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="marriage_cert">Marriage Certificate</label>
                        <input type="file" class="form-control" wire:model="marriage_cert">
                        <span class="text-danger">@error('marriage_cert') {{ $message }}@enderror</span>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="terms"></label>
                        <input type="checkbox" id="terms" wire:model="terms"> You must agree with our <a href="#">Terms and Conditions</a>
                        <span class="text-danger">@error('marriage_cert') {{ $message }}@enderror</span>
                    </div> -->
                </div>
            </div>
        </div>
        @endif


        <div class="action-button d-flex justify-content-between bg-white pt-2 pb-2">

            @if ($currentStep == 1)
            <p class="mb-0">
                <a href="{{ route('login') }}" class="text-center">I am already a Member</a>

            <div></div>
            @endif

            @if ($currentStep == 2 || $currentStep == 3)
            <button type="button" class="btn btn-md btn-secondary" wire:click="decreaseStep()">Back</button>
            @endif

            @if ($currentStep == 1 || $currentStep == 2)
            <button type="button" class="btn btn-md btn-success" wire:click="increaseStep()">Next</button>
            @endif

            @if ($currentStep == 3)
            <button type="submit" class="btn btn-md btn-primary">Submit</button>
            @endif

        </div>


    </form>
</div>