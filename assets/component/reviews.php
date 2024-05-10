

<div class="wrapper-background">
	<div class="wrapper">
		<h3>Rate your experience!</h3>
		<form action="#" method="POST">
			<div class="rating">
				<input type="number" name="rating" hidden>
				<i class='bx bx-star star' style="--i: 0;"></i>
				<i class='bx bx-star star' style="--i: 1;"></i>
				<i class='bx bx-star star' style="--i: 2;"></i>
				<i class='bx bx-star star' style="--i: 3;"></i>
				<i class='bx bx-star star' style="--i: 4;"></i>
			</div>

			<textarea name="opinion" cols="30" rows="5" placeholder="Your opinion..."></textarea>
			<div class="btn-group">
				<button type="submit" class="btn submit">Submit</button>
				<button class="btn cancel">Cancel</button>
			</div>
		</form>
	</div>
</div>



<style>
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

	:root {
		--yellow: #FFBD13;
		--blue: #4383FF;
		--blue-d-1: #3278FF;
		--light: #F5F5F5;
		--grey: #AAA;
		--white: #FFF;
		--shadow: 8px 8px 30px rgba(0, 0, 0, 0.5);
	}

	.wrapper-background {
		display: none;
		position: fixed;
		z-index: 102;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgba(0, 0, 0, 0.4);
		justify-content: center;
		align-items: center;
	}

	.wrapper {
		background: var(--white);
		padding: 2rem;
		width: 50%;
		border-radius: .75rem;
		box-shadow: var(--shadow);
		text-align: center;
		margin: 10% auto;

	}

	.wrapper h3 {
		font-size: 1.5rem;
		font-weight: 600;
		margin-bottom: 1rem;
	}

	.rating {
		display: flex;
		justify-content: center;
		align-items: center;
		grid-gap: .5rem;
		font-size: 2rem;
		color: var(--yellow);
		margin-bottom: 2rem;
		z-index: 100;
	}

	.rating .star {
		cursor: pointer;
	}

	.rating .star.active {
		opacity: 0;
		animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
	}

	@keyframes animate {
		0% {
			opacity: 0;
			transform: scale(1);
		}

		50% {
			opacity: 1;
			transform: scale(1.2);
		}

		100% {
			opacity: 1;
			transform: scale(1);
		}
	}

	.rating .star:hover {
		transform: scale(1.1);
	}

	textarea {
		width: 100%;
		background: var(--light);
		padding: 1rem;
		border-radius: .5rem;
		border: none;
		outline: none;
		resize: none;
		margin-bottom: .5rem;
	}

	.btn-group {
		display: flex;
		grid-gap: .5rem;
		align-items: center;
	}

	.btn-group .btn {
		padding: .75rem 1rem;
		border-radius: .5rem;
		border: none;
		outline: none;
		cursor: pointer;
		font-size: .875rem;
		font-weight: 500;
	}

	.btn-group .btn.submit {
		background: var(--blue);
		color: var(--white);
	}

	.btn-group .btn.submit:hover {
		background: var(--blue-d-1);
	}

	.btn-group .btn.cancel {
		background: var(--white);
		color: var(--blue);
	}

	.btn-group .btn.cancel:hover {
		background: var(--light);
	}
</style>