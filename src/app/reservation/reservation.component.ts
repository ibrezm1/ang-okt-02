import { Component } from '@angular/core';
import { HomeComponent } from '../home/home.component';
import { FormControl, ReactiveFormsModule, FormBuilder, Form, FormGroup, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatInputModule } from '@angular/material/input';
import { MatFormFieldModule } from '@angular/material/form-field';
import { CommonModule } from '@angular/common';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { provideNativeDateAdapter } from '@angular/material/core';
import { ReservationService } from '../reservation.service';
import { Router, ActivatedRoute } from '@angular/router';
@Component({
  selector: 'app-reservation',
  standalone: true,
  providers: [provideNativeDateAdapter()],
  imports: [HomeComponent, MatDatepickerModule, CommonModule, ReactiveFormsModule, MatButtonModule, MatInputModule, MatFormFieldModule],
  templateUrl: './reservation.component.html',
  styleUrl: './reservation.component.css'
})

export class ReservationComponent {
  fg: FormGroup = new FormGroup({});
  intId: number = 0;

  constructor(private fb: FormBuilder,
    private rs: ReservationService,
    private router: Router,
    private route: ActivatedRoute

  ) { }

  ngOnInit() {
    this.fg = this.fb.group({
      guestName: ['', Validators.required],
      checkInDate: ['', Validators.required],
      guestEmail: ['', Validators.required],
      roomNumber: ['', Validators.required],
    });

    let id = this.route.snapshot.paramMap.get('id')
    // convert id to number 
    this.intId = id ? parseInt(id) : 0;


    if (id) {
      this.rs.getGuestById(this.intId).subscribe(
        (response: any) => {
          if (response.success) {
            response.data.checkInDate = new Date(response.data.checkInDate);
            this.fg.patchValue(response.data);
          } else {
            console.error('Error occurred:', response.error);
          }
        },
        error => {
          console.error('Error occurred:', error);
        }
      );
    }
  }
  onSubmit() {
    console.log(this.fg.valid);
    // Checkin date convert that from 2024-03-21T04:00:00.000Z to YYYY-MM-DD
    this.fg.value.checkInDate = this.fg.value.checkInDate.toISOString().split('T')[0];
    if (!this.intId) {
      this.rs.createGuest(this.fg.value).subscribe(
        (response: any) => {
          if (response.success) {
            console.log('Guest created successfully');
          } else {
            console.error('Error occurred:', response.error);
          }
        },
        error => {
          console.error('Error occurred:', error);
        }
      );
    } else {
      // add guestId to the form group
      this.fg.value.guestId = this.intId;
      this.rs.updateGuest(this.fg.value).subscribe(
        (response: any) => {
          if (response.success) {
            console.log('Guest updated successfully');
          } else {
            console.error('Error occurred:', response.error);
          }
        },
        error => {
          console.error('Error occurred:', error);
        }
      );
    }
  }

}


